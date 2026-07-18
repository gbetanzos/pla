@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-white border-bottom">
        <h2 class="mb-0"><i class="fa-solid fa-box-open me-2"></i>Products</h2>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('products.index') }}" class="row g-2 align-items-center mb-4 p-3 bg-light rounded">
            <div class="col-auto">
                <input type="text" name="search" placeholder="Search products..." 
                    value="{{ request('search') }}" class="form-control" style="max-width: 300px;">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            @if(request('search'))
                <div class="col-auto">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            @endif
        </form>
        
        <a href="{{ route('products.create') }}" class="btn btn-success mb-3">
            <i class="fa-solid fa-plus me-1"></i> Add Product
        </a>

        @if($products->isEmpty())
            <p class="text-muted">No products found matching your filters</p>
        @else
            <div class="list-group">
                @foreach($products as $product)
                    <div class="list-group-item d-flex align-items-center p-3">
                        <div class="flex-grow-1">
                            <strong class="fs-5">{{ $product->name }}</strong>
                            @if($product->brand)
                                <small class="text-muted"><i class="fa-solid fa-tags me-1"></i>{{ $product->brand }}</small>
                            @endif
                            @if($product->price)
                                <small class="text-success fw-bold"><i class="fa-solid fa-tag me-1"></i>${{ number_format($product->price, 2) }}</small>
                            @endif
                            @if($product->notes)
                                <br><small class="text-muted d-block mt-1" style="color: #6c757d;">{{ $product->notes }}</small>
                            @endif
                            <div class="text-end mt-2">
                                @if(auth()->check())
                                   <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary btn-sm ms-2">
                                        <i class="fa-solid fa-pen me-1"></i> Modify
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
