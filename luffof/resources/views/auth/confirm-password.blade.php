@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-3">Confirm Password</h2>
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary">Confirm</button>
        </form>
        <p class="mt-3">Back to dashboard? <a href="{{ route('dashboard') }}">Dashboard</a></p>
    </div>
</div>
@endsection