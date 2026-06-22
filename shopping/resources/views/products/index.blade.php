@extends('layouts.app')

@section('content')
<div class="items-list">
    <h2>Products</h2>
    <div style="margin: 15px 0;">
        <form method="GET" action="{{ route('products.index') }}" style="display: flex; gap: 10px; box-shadow: rgba(0,0,0,0.1); padding: 10px; border-radius: 5px;">
            <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; flex: 1; max-width: 300px;">
            <select name="priority" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">All Priorities</option>
                <option value="1" {{ request('priority') == '1' ? 'selected' : '' }}>High</option>
                <option value="2" {{ request('priority') == '2' ? 'selected' : '' }}>Medium</option>
                <option value="3" {{ request('priority') == '3' ? 'selected' : '' }}>Low</option>
            </select>
            <button type="submit" style="padding: 8px 16px; border: none; background: #1976#2244; color: white; border-radius: 4px; cursor: pointer;">Filter</button>
            @if(request('search') || request('priority'))
                <a href="{{ route('products.index') }}" style="padding: 8px 16px; border: 1px solid #ddd; background: white; color: #333; text-decoration: none; border-radius: 4px; cursor: pointer;">Reset</a>
            @endif
        </form>
    </div>
    
    <a href="{{ route('products.create') }}" class="btn btn-success" style="margin: 15px 0;">+ Add Product</a>
    
    @if($products->isEmpty())
        <p>No products foundmatching your filters</p>
    @else
        @foreach($products as $product)
            <div class="items-list-item {{ $product->brand ? '' : 'checked' }}" style="
                background: {{ $product->brand ? '#fff' : '#e8f5e9' }},
                border-left: {{ $product->priority == 1 ? '4px solid #dc3545' : '' }},
                {{ $product->priority == 2 ? '4px solid #ffc107' : '' }},
                {{ $product->priority == 3 ? '4px solid #28a745' : '' }}>
                <input type="checkbox" class="items-list-item-checkbox" id="p{{ $product->id }}" {{ $product->brand ? '' : 'checked' }}>
                <span class="items-list-item-title">
                    <strong>{{ $product->name }}</strong>
                    @if($product->brand) <small><em>Brand: {{ $product->brand }}</em></small> @endif
                    @if($product->notes) <br><small><em>{{ $product->notes }}</em></small> @endif
                    <small style="float: right;">
                        @if($product->priority == 1) <span style="color: #dc3545">● High</span>
                        @elseif($product->priority == 2) <span style="color: #ffc107">● Medium</span>
                        @else <span style="color: #28a745">● Low</span>
                        @endif
                    </small>
                </span>
            </div>
        @endforeach
    @endif
</div>
@endsection
