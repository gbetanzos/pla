@extends('layouts.app')

@section('content')
<div class="items-list-item" style="background: {{ $list->priority === 'high' ? '#fdf2f2' : $list->priority === 'medium' ? '#fdf6e3' : '#eafaf1' }}">
    <h2>{{ $list->title }}</h2>
    @if($list->description)
        <p>{{ $list->description }}</p>
    @endif
    <div style="margin: 15px 0; padding: 10px; background: #f8f9fa; border-radius: 4px;">
        <p style="margin: 0 0 5px 0;"><strong>P:</strong> {{ ucfirst($list->priority) }}</p>
        @if($list->due_date)
            <p style="margin: 0;"><em>Due: {{ $list->due_date->format('M d, Y') }}</em></p>
        @endif
    </div>
    
    <a href="{{ route('shopping-lists.edit', $list) }}" class="btn btn-primary">Edit List</a>
    <a href="{{ route('shopping-lists.destroy', $list) }}" class="btn btn-danger">Delete List</a>
    
    <h3 style="margin: 25px 0 10px;">Items</h3>
    <div class="items-list">
        @forelse($items as $item)
            <div class="items-list-item">
                <input type="checkbox" class="items-list-item-checkbox" id="i{{ $item['product_id'] }}" data-id="{{ $item['product_id'] }}" {{ $item['checked'] ? 'checked' : '' }}>
                <label for="i{{ $item['product_id'] }}" class="items-list-item-title">
                    @if($item['product_id'])
                        {{ $item['name'] }}
                        @if($item['brand']) <small><em>{{ $item['brand'] }}</em></small> @endif
                    @else
                        <!-- Product not found in database -->
                    @endif
                </label>
            </div>
        @empty
            <p style="color: #999;">No items yet. Use products below to add items.</p>
        @endforelse
    </div>
    
    <h3 style="margin: 25px 0 10px;">Product Catalog</h3>
    <div class="items-list">
        @forelse($products as $product)
            <div class="items-list-item">
                <label style="display: flex; align-items: flex-start; cursor: pointer;" for="p{{ $product->id }}">{{ $list->items ? ' ' : '+' }}
                    <input type="checkbox" id="p{{ $product->id }}" data-product-id="{{ $product->id }}" data-product-name="{{ str_replace(' ', '&nbsp;', $product->name) }}" data-product-brand="{{ json_encode($product->brand) }}" data-product-notes="{{ json_encode($product->notes) }}">
                    &nbsp;
                    <strong>{{ $product->name }}</strong>
                    @if($product->brand) <small><em>{{ $product->brand }}</em></small> @endif
                    @if($product->notes) <br><small><em>{{ $product->notes }}</em></small> @endif
                </label>
            </div>
        @empty
            <p style="color: #999;">No products available.</p>
        @endforelse
    </div>
</div>
@endsection
