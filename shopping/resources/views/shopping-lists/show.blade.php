@extends('layouts.app')

@section('content')
@php
    $isCompleted = $list->is_completed || ($list->items && !($list->items->pluck('checked')->contains(false)));
    $bgColor = $isCompleted ? '#f0f0f0' : (
        $list->priority === 'high' ? '#fdf2f2' :
        $list->priority === 'medium' ? '#fdf6e3' : '#eafaf1'
    );
@endphp

<div class="items-list-item" style="padding-top: 30px; border-left: 4px solid {{ $isCompleted ? '#27ae60' : '' }}">
    <h2 style="margin: 0;">
        {{ $list->title }}
        {{ $isCompleted ? '<small style="color: #27ae60;">✔</small>' : '' }}
        <form method="POST" action="{{ route('shopping-lists.mark-complete', $list)" style="display: inline;">
            @csrf
            <button type="submit" {{ $isCompleted ? 'style="display: none;"' : 'style="background: #27ae60; border: none; color: white; padding: 4px 8px; border-radius: 3px; cursor: pointer; font-size: 11px;"' }}>✔ Done</button>
        </form>
    </h2>
    <div style="margin: 10px 0; padding: 10px; background: #f8f9fa; border-radius: 4px;">
        <p style="margin: 0;"><strong>P:</strong> {{ ucfirst($list->priority) }}
        @if($list->due_date) <span style="margin-left: 15px; color: #666;">Due: {{ $list->due_date->format('M d, Y') }}</span> @endif
        </p>
    </div>
    
    <div style="display: flex; gap: 10px; margin: 15px 0;">
        <a href="{{ route('shopping-lists.edit', $list) }}" class="btn btn-primary">Edit</a>
        <form method="POST" action="{{ route('shopping-lists.destroy', $list) }}" data-confirm="true" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
    
    <h3 style="margin: 25px 0 10px;">Items</h3>
    <div class="items-list">
        @forelse($items as $item)
            <div class="items-list-item" style="display: flex; align-items: center; padding: 10px 8px;">
                <input type="checkbox" class="items-list-item-checkbox" id="i{{ $item['product_id'] }}" data-id="{{ $item['product_id'] }}" {{ $item['checked'] ? 'checked' : '' }}>
                <label for="i{{ $item['product_id'] }}" style="margin-left: 10px;">
                    @if($item['product_id'])
                        {{ $item['name'] }}
                        @if($item['brand']) <small style="color: #666;"><em>{{ $item['brand'] }}</em></small> @endif
                    @endif
                </label>
            </div>
        @empty
            <p style="color: #999;">No items yet. Add from products below.</p>
        @endforelse
    </div>
    
    <h3 style="margin: 25px 0 10px;">Add From Product Catalog</h3>
    <div class="items-list">
        @forelse($products as $product)
            <div class="items-list-item">
                <label style="display: flex; align-items: flex-start; cursor: pointer;" for="p{{ $product->id }}">{{ $list->items ? ' ' : '+' }}
                    <input type="checkbox" id="p{{ $product->id }}" data-product-id="{{ $product->id }}" data-product-name="{{ str_replace(' ', '&nbsp;', $product->name) }}" data-product-brand="{{ json_encode($product->brand) }}">
                    &nbsp;
                    <strong>{{ $product->name }}</strong>
                    @if($product->brand) <small style="color: #666;"><em>{{ $product->brand }}</em></small> @endif
                </label>
            </div>
        @empty
            <p style="color: #999;">No products available.</p>
        @endforelse
    </div>
</div>
@endsection
