@extends('layouts.app')

@section('content')
@php
    $itemsArray = is_array($list->items) ? $list->items : (is_string($list->items) ? json_decode($list->items, true) : []);
    if (!is_array($itemsArray)) {
        $itemsArray = [];
    }
    $isCompleted = $list->is_completed || (count($itemsArray) > 0 && !collect($itemsArray)->pluck('checked')->contains(false));
@endphp

<div class="card {{ $isCompleted ? 'bg-light' : '' }}" 
      style="border-left: 4px solid {{ ($list->priority === 'high') ? '#dc3545' : (($list->priority === 'medium') ? '#ffc107' : '#28a745') }}">
    <div class="card-header bg-transparent text-muted">
        <h2 class="mb-0">
        @if(count($itemsArray) > 0 && !collect($itemsArray)->pluck('checked')->contains(false))
            <i class="fa-solid fa-check-circle text-success me-2"></i>
            @endif
            {{ $list->title }}
            @if($isCompleted)
                <i class="fa-solid fa-check text-success ms-2"></i>
            @endif
            @if($list->priority === 'high')
                <span class="badge bg-danger">HIGH</span>
            @elseif($list->priority === 'medium')
                <span class="badge bg-warning text-dark">MEDIUM</span>
            @endif
            @if($list->due_date)
                <small class="text-muted ms-2" title="Due Date">Due: {{ $list->due_date->format('M d, Y') }}</small>
            @endif
        </h2>
        <form method="POST" action="{{ route('shopping-lists.mark-complete', $list) }}"
              style="display: inline;">
            @csrf
            <button type="submit" 
                    {{ $isCompleted ? 'style="visibility: hidden;"' : 'style="display: inline-block;"' }} 
                    class="btn btn-sm btn-success">
                <i class="fa-solid fa-check"></i> Done
            </button>
        </form>
    </div>
    <div class="card-body bg-light">
        <p class="mb-2"><i class="fa-solid fa-gear me-1"></i> {{ ucfirst($list->priority) }} Priority</p>
        @if($list->due_date)
            <p class="text-muted mb-0">
                <i class="fa-regular fa-clock me-1"></i> 
                Due: {{ $list->due_date->format('M d, Y') }}
            </p>
        @endif
    </div>
    
    @if(!empty($itemsArray))
    <div class="card-body">
        <h5 class="mb-3"><i class="fa-solid fa-list-check me-1"></i> Items ({{ $list->completed_percentage }})</h5>
        <div class="list-group">
            @foreach($itemsArray as $index => $item)
                @php
                    $product = $products->firstWhere('id', $item['product_id']);
                @endphp
                <div class="list-group-item d-flex align-items-center items-list-item {{ $item['checked'] ? 'completed' : '' }}"
                     style="{{ $item['checked'] ? 'opacity: 0.6; background: #f8f9fa;' : '' }}">
                    <input class="form-check-input me-3 items-list-item-checkbox" type="checkbox"
                           data-product-id="{{ $item['product_id'] }}"
                           {{ $item['checked'] ? 'checked' : '' }}>
                    <div class="flex-grow-1">
                        <strong>{{ $product ? $product->name : 'Unknown Product' }}</strong>
                        @if($product && $product->brand)
                            <br><small class="text-muted">{{ $product->brand }}</small>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="card-body text-center">
        <p class="text-muted mb-0"><i class="fa-solid fa-inbox me-1"></i> No items on this list yet</p>
    </div>
    @endif

    <div class="card-footer bg-transparent">
        <a href="{{ route('shopping-lists.edit', $list) }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-pen"></i> Edit
        </a>
        <form method="POST" action="{{ route('shopping-lists.destroy', $list) }}" data-confirm="true"
              style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fa-solid fa-trash"></i> Delete
            </button>
        </form>
    </div>
</div>
    
    <script>
    (function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        // Toggle complete state handler
        document.querySelectorAll('.items-list-item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const productId = this.dataset.productId;
                const checked = this.checked;
                const row = this.closest('.items-list-item');
                
                if (!productId) return;
                
                fetch(`/shopping-list/{{ $list->id }}/toggle-item`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        item_id: productId,
                        checked: checked
                    })
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        row.classList.toggle('completed', checked);
                    } else {
                        alert(data.message || 'Error toggling item');
                    }
                }).catch(err => console.error(err));
            });
        });
    })();
    </script>
</div>
@endsection
