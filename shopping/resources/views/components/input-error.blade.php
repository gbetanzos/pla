@props(['messages'])

@if ($messages)
    <div class="text-danger text-small my-2" role="alert">
        @foreach ((array) $messages as $message)
            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
        @endforeach
    </div>
@endif
