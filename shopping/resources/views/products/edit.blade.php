@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-light">
        <h2 class="mb-0"><i class="fa-solid fa-scissors me-2"></i>Edit Product</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('product.update', $product) }}" method="PUT">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" 
                       value="{{ old('brand', $product->brand) }}">
                <div class="form-text">Leave empty if not applicable</div>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price (optional)</label>
                <input type="number" class="form-control" id="price" name="price" 
                       value="{{ old('price', $product->price) }}" step="0.01" min="0">
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $product->notes) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select class="form-select" id="priority" name="priority">
                    <option value="1" {{ old('priority', $product->priority) == 1 ? 'selected' : '' }}>High</option>
                    <option value="2" {{ old('priority', $product->priority) == 2 ? 'selected' : '' }}>Medium</option>
                    <option value="3" {{ old('priority', $product->priority) == 3 ? 'selected' : '' }}>Low</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Update</button>
                <a href="{{ route('shopping-list.index') }}" class="btn btn-success">
                    <i class="fa-solid fa-list me-1"></i>All Lists
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
