<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingList;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    protected function authorize(ShoppingList $list)
    {
        abort_if($list->user_id !== auth()->id(), 403);
    }

    protected function collectItems(Request $request): array
    {
        return collect((array)$request->product_ids)
            ->map(fn($productId) => ['product_id' => (int)$productId, 'checked' => false])
            ->values()
            ->all();
    }

    public function index()
    {
        $query = ShoppingList::where('user_id', auth()->id());

        switch (request('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'priority':
                $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')");
                break;
            case 'due_date':
                $query->orderBy('due_date', 'asc')->whereNotNull('due_date')->union(
                    ShoppingList::whereNull('due_date')->orderBy('created_at', 'desc')
                );
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $lists = $query->get();
        return view('shopping-lists.index', ['lists' => $lists]);
    }

    public function store(Request $request)
    {
        $user = $request->user() ?? abort(401);

        $data = [
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
        ];

        $data = array_merge($data, $this->collectItems($request));
        $list = ShoppingList::create($data);
        return redirect()->route('shopping-lists.index')->with('success', 'Shopping list created.');
    }

    public function show(ShoppingList $list)
    {
        $this->authorize($list);
        $products = Product::all();
        $items = json_decode($list->items, true) ?: [];
        $totalCost = 0;

        foreach ($items as $item) {
            if (isset($item['product_id'])) {
                $product = $products->find($item['product_id']);
                if ($product && $product->price) {
                    $totalCost += $product->price;
                }
            }
        }

        return view('shopping-lists.show', ['list' => $list, 'products' => $products, 'totalCost' => number_format($totalCost, 2)]);
    }

    public function create()
    {
        $products = Product::all();
        return view('shopping-lists.create', ['products' => $products]);
    }

    public function edit(ShoppingList $list)
    {
        $this->authorize($list);
        $products = Product::all();
        return view('shopping-lists.edit', ['list' => $list, 'products' => $products]);
    }

    public function update(Request $request, ShoppingList $list)
    {
        $this->authorize($list);
        $data = $request->only(['title', 'description', 'priority', 'due_date', 'notes']);

        $list->update(array_merge($data, $this->collectItems($request)));
        return redirect()->route('shopping-lists.show', $list)->with('success', 'Shopping list updated.');
    }

    public function toggleItem(Request $request, ShoppingList $list)
    {
        $this->authorize($list);
        $itemId = (int)$request->item_id;
        $items = json_decode($list->items, true) ?? [];

        foreach ($items as &$item) {
            if ((int)$item['product_id'] === $itemId) {
                $item['checked'] = $request->boolean('checked') ? true : !$item['checked'];
            }
        }

        $list->items = json_encode($items);
        $list->save();

        return response()->json(['success' => true]);
    }

    public function duplicate(ShoppingList $list)
    {
        $this->authorize($list);
        $newData = [
            'user_id' => auth()->id(),
            'title' => $list->title . ' (Copy)',
            'description' => $list->description,
            'priority' => $list->priority,
            'due_date' => $list->due_date,
            'items' => $list->items,
        ];

        $newList = ShoppingList::create($newData);

        return redirect()->route('shopping-lists.show', $newList)->with('success', 'Shopping list duplicated.');
    }

    public function markComplete(Request $request, ShoppingList $list)
    {
        $this->authorize($list);
        $list->is_completed = true;
        $list->completed_at = now();
        $list->save();

        return redirect()->route('shopping-lists.show', $list);
    }

    public function addItem(Request $request, ShoppingList $list)
    {
        $this->authorize($list);
        $productIds = $request->filled('product_ids')
            ? (array)$request->product_ids
            : (is_array($request->product_id) ? $request->product_id : [$request->product_id]);

        if (empty($productIds)) {
            return response()->json(['error' => 'No product specified'], 400);
        }

        $items = json_decode($list->items, true) ?: [];
        $count = 0;

        foreach ($productIds as $productId) {
            $productId = (int)$productId;
            $qty = max(1, (int)($request->input("product_quantities.$productId", 1)));
            $alreadyExists = false;
            foreach ($items as $item) {
                if ((int)$item['product_id'] === $productId) {
                    $alreadyExists = true;
                    break;
                }
            }
            if (!$alreadyExists) {
                for ($i = 0; $i < $qty; $i++) {
                    $items[] = ['product_id' => $productId, 'checked' => false];
                    $count++;
                }
            }
        }

        $list->items = json_encode($items);
        $list->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'count' => $count]);
        }

        return redirect()->route('shopping-lists.show', $list)
            ->with('success', "$count product(s) added.");
    }

    public function destroy(ShoppingList $list)
    {
        $this->authorize($list);
        $list->delete();

        return redirect()->route('shopping-lists.index')->with('success', 'Shopping list deleted.');
    }
}
