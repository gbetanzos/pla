<x-guest-layout>
    <section class="mb-4">
        <h2 class="h4 mb-3"><i class="fas fa-key me-2"></i> Forgot Password?</h2>
    </section>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control @error('email') is-invalid @enderror">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end mb-3">
            <button type="submit" class="btn btn-primary">Email Reset Link</button>
        </div>
    </form>
    <div class="text-center mt-3"><a href="{{ route('login') }}" class="small text-decoration-none fw-bold text-primary">&larr; Back to Log In</a></div>
</x-guest-layout>
