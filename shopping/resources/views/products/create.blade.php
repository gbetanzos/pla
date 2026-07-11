@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-light">
        <h2 class="mb-0"><i class="fa-solid fa-plus-circle me-2"></i>Add Product</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" 
                       value="{{ old('brand') }}">
                <div class="form-text">Leave empty if not applicable</div>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price (optional)</label>
                <input type="number" class="form-control" id="price" name="price" 
                       value="{{ old('price') }}" step="0.01" min="0">
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Add Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
