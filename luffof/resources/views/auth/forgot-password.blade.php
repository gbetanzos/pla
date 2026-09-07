@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-3">Forgot Your Password?</h2>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
        </form>
        <p class="mt-3">Remember your password? <a href="{{ route('login') }}">Login</a></p>
    </div>
</div>
@endsection