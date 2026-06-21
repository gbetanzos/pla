@extends('layouts.app')

@section('content')
<div class="items-list">
    <h2>Products</h2>
    <a href="{{ route('products.create') }}" class="btn btn-success" style="margin: 15px 0;">+ Add Product</a>
    
    @if($products->isEmpty())
        <p>No products yet. Create your first one!</p>
    @else
        @foreach($products as $product)
            <div class="items-list-item {{ $product->brand ? '' : 'checked' }}" style="background: {{ $product->brand ? '#fff' : '#e8f5e9' }}">
                <input type="checkbox" class="items-list-item-checkbox" id="p{{ $product->id }}" {{ $product->brand ? '' : 'checked' }}>
                <span class="items-list-item-title">
                    <strong>{{ $product->name }}</strong>
                    @if($product->brand) <small><em>Brand: {{ $product->brand }}</em></small> @endif
                    @if($product->notes) <br><small><em>{{ $product->notes }}</em></small> @endif
                </span>
            </div>
        @endforeach
    @endif
</div>
@endsection
