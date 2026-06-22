<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function index()
    {
        $lists = ShoppingList::orderBy('created_at', 'desc')->get();
        return view('shopping-lists.index', ['lists' => $lists]);
    }

    public function create()
    {
        return view('shopping-lists.create');
    }

    public function store(Request $request)
    {
        ShoppingList::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
        ]);
        return redirect()->route('shopping-lists.index')->with('success', 'Shopping list created.');
    }

    public function show(ShoppingList $list)
    {
        $list->load('products');
        $items = json_decode($list->items, true) ?? [];
        return view('shopping-lists.show', ['list' => $list, 'items' => $items]);
    }

    public function edit(ShoppingList $list)
    {
        return view('shopping-lists.edit', ['list' => $list]);
    }

    public function update(Request $request, ShoppingList $list)
    {
        $data = $request->only(['title', 'description', 'priority', 'due_date', 'notes']);
        
        if ($request->has('items')) {
            $updatedItems = [];
            foreach ($request->items as $itemId => $item) {
                $updatedItems[] = [
                    'product_id' => $item['product_id'] ?? null,
                    'checked' => $item['checked'] ?? false,
                ];
            }
            $data['items'] = json_encode($updatedItems);
        }

        $list->update($data);
        return redirect()->route('shopping-lists.show', $list)->with('success', 'Shopping list updated.');
    }

    public function toggleItem(Request $request, ShoppingList $list)
    {
        $itemId = (int)$request->item_id;
        $items = json_decode($list->items, true) ?? [];
        
        foreach ($items as &$item) {
            if ($item['product_id'] === $itemId) {
                $item['checked'] = !$item['checked'];
            }
        }
        
        $list->items = json_encode($items);
        $list->save();
        
        return redirect()->route('shopping-lists.show', $list);
    }

    public function destroy(ShoppingList $list)
    {
        if (!$request('confirm')) {
            return abort(400, 'Please confirm deletion.');
        }
        
        $list->delete();
        return redirect()->route('shopping-lists.index')->with('success', 'Shopping list deleted.');
    }

    public function toggle(Request $request, ShoppingList $list)
    {
        $itemId = (int)$request->item_id;
        $items = json_decode($list->items, true) ?? [];
        
        foreach ($items as &$item) {
            if ($item['product_id'] === $itemId) {
                $item['checked'] = !$item['checked'];
            }
        }
        
        $list->items = json_encode($items);
        $list->save();
        
        return redirect()->route('shopping-lists.show', $list);
    }

    public function markComplete(Request $request, ShoppingList $list)
    {
        $list->is_completed = true;
        $list->completed_at = now();
        $list->save();
        
        return redirect()->route('shopping-lists.show', $list);
    }
}