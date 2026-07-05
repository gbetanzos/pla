<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingList;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function index()
    {
        $query = ShoppingList::query();

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

        if ($request->has('product_ids')) {
            $items = [];
            foreach ((array)$request->product_ids as $productId) {
                $items[] = ['product_id' => (int)$productId, 'checked' => false];
            }
            $data['items'] = json_encode($items);
        }

        ShoppingList::create($data);
        return redirect()->route('shopping-lists.index')->with('success', 'Shopping list created.');
    }

    public function show(ShoppingList $list)
    {
        $products = Product::all();
        return view('shopping-lists.show', ['list' => $list, 'products' => $products]);
    }

    public function create()
    {
        $products = Product::all();
        return view('shopping-lists.create', ['products' => $products]);
    }

    public function edit(ShoppingList $list)
    {
        $products = Product::all();
        return view('shopping-lists.edit', ['list' => $list, 'products' => $products]);
    }

    public function update(Request $request, ShoppingList $list)
    {
        $data = $request->only(['title', 'description', 'priority', 'due_date', 'notes']);

        if ($request->has('product_ids')) {
            $productIds = (array)$request->product_ids;
            $items = json_decode($list->items, true) ?: [];
            
            foreach ($items as &$item) {
                $item['checked'] = false;
            }
            
            $newItems = [];
            foreach ($productIds as $productId) {
                $productId = (int)$productId;
                $alreadyExists = false;
                foreach ($items as $idx => $item) {
                    if ((int)$item['product_id'] === $productId) {
                        $newItems[$idx] = $item;
                        $alreadyExists = true;
                    } else {
                        unset($items[$idx]);
                    }
                }
                if (!$alreadyExists) {
                    $items[] = ['product_id' => $productId, 'checked' => false];
                    $newItems[key($items)] = end($items);
                }
            }
            
            $data['items'] = json_encode(array_values($items));
        }

        $list->update($data);
        return redirect()->route('shopping-lists.show', $list)->with('success', 'Shopping list updated.');
    }

    public function toggleItem(Request $request, ShoppingList $list)
    {
        $itemId = (int)$request->item_id;
        $items = json_decode($list->items, true) ?? [];

        foreach ($items as &$item) {
            if ((int)$item['product_id'] === $itemId) {
                $item['checked'] = !$item['checked'];
            }
        }

        $list->items = json_encode($items);
        $list->save();

        return response()->json(['success' => true]);
    }

    public function destroy(ShoppingList $list)
    {
        if (!$request('confirm')) {
            return abort(400, 'Please confirm deletion.');
        }
        
        $list->delete();
        return redirect()->route('shopping-lists.index')->with('success', 'Shopping list deleted.');
    }

    public function markComplete(Request $request, ShoppingList $list)
    {
        $list->is_completed = true;
        $list->completed_at = now();
        $list->save();

        return redirect()->route('shopping-lists.show', $list);
    }

    public function addItem(Request $request, ShoppingList $list)
    {
        $productIds = $request->filled('product_ids')
            ? (array)$request->product_ids
            : (is_array($request->product_id) ? $request->product_id : [$request->product_id]);

        if (empty($productIds)) {
            return response()->json(['error' => 'No product specified'], 400);
        }

        $items = json_decode($list->items, true) ?: [];

        foreach ($productIds as $productId) {
            $productId = (int)$productId;
            $alreadyExists = false;
            foreach ($items as $item) {
                if ((int)$item['product_id'] === $productId) {
                    $alreadyExists = true;
                    break;
                }
            }
            if (!$alreadyExists) {
                $items[] = ['product_id' => $productId, 'checked' => false];
            }
        }

        $list->items = json_encode($items);
        $list->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'count' => count($items)]);
        }

        return redirect()->route('shopping-lists.show', $list)
            ->with('success', count($productIds) . ' product(s) added.');
    }
}