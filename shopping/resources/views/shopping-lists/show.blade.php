@extends('layouts.app')

@section('content')
@php
    $isCompleted = $list->is_completed || ($list->items && !($list->items->pluck('checked')->contains(false)));
    $bgColor = $isCompleted ? '#f0f0f0' : (
        $list->priority === 'high' ? '#fdf2f2' :
        $list->priority === 'medium' ? '#fdf6e3' : '#eafaf1'
    );
@endphp

<div class="card {{ $isCompleted ? 'bg-light' : '' }}" 
     style="border-left: 4px solid {{ $list->priority === 'high' ? '#dc3545' : ($list->priority === 'medium' ? '#ffc107' : '#28a745') }}">
    <div class="card-header bg-transparent text-muted">
        <h2 class="mb-0">
            @if($list->items && !($list->items->pluck('checked')->contains(false)))
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
        <form method="POST" action="{{ route('shopping-list.mark-complete', $list) }}" 
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
    
    <div class="card-footer bg-transparent">
        <a href="{{ route('shopping-list.edit', $list) }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-pen"></i> Edit
        </a>
        <form method="POST" action="{{ route('shopping-list.destroy', $list) }}" data-confirm="true" 
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
                
                fetch('/shopping-list/{{ $list->id }}/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        product_id: productId,
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
