@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-group">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">← Back to products</a>
        <a href="{{ route('products.show', $product) }}" class="btn btn-info">View Product</a>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Edit Product</a>
    </div>

    <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: rgba(0,0,0,0.1);">
        <h2>Edit Product</h2>

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand', $product->brand) }}">
                <small class="form-text text-muted">Leave empty if not applicable</small>
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $product->notes) }}</textarea>
            </div>

            <div class="form-group">
                <label for="priority">Priority</label>
                <select class="form-control" id="priority" name="priority">
                    <option value="1" {{ old('priority', $product->priority) == 1 ? 'selected' : '' }}>1 - High</option>
                    <option value="2" {{ old('priority', $product->priority) == 2 ? 'selected' : '' }}>2 - Medium</option>
                    <option value="3" {{ old('priority', $product->priority) == 3 ? 'selected' : '' }}>3 - Low</option>
                </select>
            </div>

            <hr>

            <div>
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('shopping-lists.index') }}" class="btn btn-success">View All Shopping Lists</a>
            </div>
        </form>
    </div>
</div>
@endsection
