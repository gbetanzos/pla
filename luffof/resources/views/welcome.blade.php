@extends('layouts.app')

@section('content')
<div class="text-center mb-5">
    <h1 class="display-4">Welcome to {{ config('app.name') }}</h1>
    <p class="lead">Blood pressure tracker to help you monitor your health.
    @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go to Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary mt-3">Login</a>
    @endauth
    </p>
</div>
@endsection