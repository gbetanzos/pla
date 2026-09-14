<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        @guest
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        @else
        <li class="nav-item"><a class="nav-link" href="{{ route('bp.index') }}">Blood Pressure</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Profile</a></li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
@yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
