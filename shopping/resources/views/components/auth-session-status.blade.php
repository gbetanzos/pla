@props(['status'])

@if ($status)
    <div class="alert alert-success mb-4" role="alert">
        <i class="fas fa-check-circle me-1"></i>
        {{ $status }}
    </div>
@endif
