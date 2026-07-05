<x-guest-layout>
    <section class="mb-4">
        <h2 class="h4 mb-3"><i class="fas fa-sign-in-alt me-2 text-primary"></i> Welcome Back</h2>
    </section>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control @error('email') is-invalid @enderror">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3"><div class="form-check">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
            <label class="form-check-label text-secondary" for="remember_me">{{ __('Remember me') }}</label>
        </div></div>

        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small text-decoration-none text-secondary">Forgot your password?</a>
            @else<div></div>@endif
            <button type="submit" class="btn btn-primary ms-auto">Log in</button>
        </div>
    </form>

    <div class="text-center mt-3"><p class="text-muted small mb-0">Don't have an account?@if(route('register')) <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-primary">Sign Up</a>@endif</p></div>
</x-guest-layout>
