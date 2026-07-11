@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Edit Shopping List</h2>

    <a href="{{ route('shopping-lists.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Cancel
    </a>
</div>

<form action="{{ route('shopping-lists.update', $list) }}" method="POST"
      class="card shadow-sm border-0"
      style="padding: 30px; background: #f8f9fa;">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="title" class="form-label fw-bold">Title <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-lg"
               id="title" name="title" value="{{ $list->title }}" required>
    </div>

    <div class="mb-4">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control"
                  id="description" name="description"
                  rows="2">{{ $list->description }}</textarea>
    </div>

    <div class="row align-items-end">
        <div class="col-md-4 mb-3">
            <label for="priority" class="form-label fw-bold">Priority <span class="text-danger">*</span></label>
            <select class="form-select" id="priority" name="priority" required>
                <option value="">None</option>
                <option value="high" {{ old('priority', $list->priority) === 'high' ? 'selected' : '' }} class="text-danger fw-bold">High</option>
                <option value="medium" {{ old('priority', $list->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="low" {{ old('priority', $list->priority) === 'low' ? 'selected' : '' }}>Low</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control"
                   id="due_date"
                   name="due_date"
                   value="{{ $list->due_date ? $list->due_date->format('Y-m-d') : '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control"
                      id="notes" name="notes"
                      rows="2">{{ $list->notes }}</textarea>
        </div>
    </div>

    <div class="mt-4">
        <label class="form-label fw-bold">Items</label>
        <p class="text-muted mb-2"><small>Select which products belong on this list:</small></p>
        @php
            $currentItems = is_array($list->items) ? $list->items : (is_string($list->items) ? json_decode($list->items, true) : []);
            if (!is_array($currentItems)) {
                $currentItems = [];
            }
        @endphp
        @if($products->count())
        <div style="max-height: 300px; overflow-y: auto; border: 2px solid #dee2e6; border-radius: 8px; padding: 15px;">
            @foreach($products as $product)
                @php
                    $isChecked = false;
                    foreach ($currentItems as $item) {
                        if ((int)$item['product_id'] === (int)$product->id) {
                            $isChecked = true;
                            break;
                        }
                    }
                @endphp
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="product_ids[]" value="{{ $product->id }}"
                           id="edit_prod_{{ $product->id }}" {{ $isChecked ? 'checked' : '' }}>
                    <label class="form-check-label" for="edit_prod_{{ $product->id }}">
                        <strong>{{ $product->name }}</strong>
                        @if($product->brand)
                            <small class="text-muted ms-1">({{ $product->brand }})</small>
                        @endif
                    </label>
                </div>
            @endforeach
        </div>
        @endif
    </div>

    <div class="d-flex gap-2 mt-4 pt-2 border-top">
        <button type="submit" class="btn btn-success flex-grow-1">Update List</button>
    </div>
</form>
@endsection
