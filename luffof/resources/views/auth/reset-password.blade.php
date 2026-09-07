@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-3">Reset Password</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="token" value="{{ $token }}"/>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $email ?? old('email') }}" required readonly>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
        <p class="mt-3">Remember your password? <a href="{{ route('login') }}">Login</a></p>
    </div>
</div>
@endsection