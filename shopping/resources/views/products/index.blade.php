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
                <select name="priority" class="form-select">
                    <option value="">All Priorities</option>
                    <option value="1" {{ request('priority') == '1' ? 'selected' : '' }}>High</option>
                    <option value="2" {{ request('priority') == '2' ? 'selected' : '' }}>Medium</option>
                    <option value="3" {{ request('priority') == '3' ? 'selected' : '' }}>Low</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            @if(request('search') || request('priority'))
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
                    <label class="list-group-item d-flex align-items-center p-3 {{ $product->brand ? '' : 'active' }}" 
                           style="{{ $product->priority == 1 ? 'border-left: 4px solid #dc3545;' : '' }}
                                   {{ $product->priority == 2 ? 'border-left: 4px solid #ffc107;' : '' }}
                                   {{ $product->priority == 3 ? 'border-left: 4px solid #28a745;' : '' }}">
                        <input type="checkbox" class="form-check-input me-2" 
                               id="p{{ $product->id }}" {{ $product->brand ? '' : 'checked' }}>
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
                                @if($product->priority == 1)
                                    <span class="badge bg-danger"><i class="fa-solid fa-fire me-1"></i>High</span>
                                @elseif($product->priority == 2)
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-fire-extinguisher me-1"></i>Medium</span>
                                @else
                                    <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i>Low</span>
                                @endif
                                @if(auth()->check())
                                   <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-secondary ms-2">
                                        <i class="fa-solid fa-pen me-1"></i> Modify
                                    </a>
                                @endif
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
