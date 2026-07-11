@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-0"><i class="fa-solid fa-box-open me-2"></i>{{ $product->name }}</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        @if($product->brand)
            <p class="mb-2"><i class="fa-solid fa-tags me-1"></i><strong>Brand:</strong> {{ $product->brand }}</p>
        @endif

        @if($product->price)
            <p class="mb-2"><i class="fa-solid fa-dollar-sign me-1"></i><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
        @endif

        @if($product->notes)
            <p class="mb-2"><i class="fa-solid fa-sticky-note me-1"></i><strong>Notes:</strong> {{ $product->notes }}</p>
        @endif

        <p class="text-muted mb-0"><small>Added {{ $product->created_at->diffForHumans() }}</small></p>
    </div>
    <div class="card-footer bg-transparent d-flex gap-2">
        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-pen me-1"></i>Edit
        </a>
        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline;"
              onsubmit="return confirm('Are you sure you want to delete this product?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fa-solid fa-trash me-1"></i>Delete
            </button>
        </form>
    </div>
</div>
@endsection
