@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if(auth()->check())
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-4">
                        <!-- Welcome Section -->
                        <div class="mb-4">
                            <h2 class="fw-bold text-dark mb-1">
                                <i class="fa-solid fa-user-circle me-2 text-primary"></i>
                                {{ auth()->user()->name }}
                            </h2>
                            <p class="text-muted">Your Shopping Dashboard</p>
                        </div>

                        <!-- Stats Grid -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm text-center p-3">
                                    <div class="card-body">
                                        <i class="fa-solid fa-bag-shopping fa-3x mb-3 text-primary"></i>
                                        <h5 class="card-title text-muted">Shopping Lists</h5>
                                        <p class="display-5 fw-bold text-dark mb-0">
                                            {{ auth()->user()->shoppingLists()->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm text-center p-3">
                                    <div class="card-body">
                                        <i class="fa-solid fa-clipboard-check fa-3x mb-3 text-success"></i>
                                        <h5 class="card-title text-muted">Active Items</h5>
                                        <p class="display-5 fw-bold text-dark mb-0">
                                            {{ auth()->user()->shoppingLists()->where('is_completed', false)->pluck('items')->flatten()->where('checked', false)->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm text-center p-3">
                                    <div class="card-body">
                                        <i class="fa-solid fa-boxes fa-3x mb-3 text-info"></i>
                                        <h5 class="card-title text-muted">Products</h5>
                                        <p class="display-5 fw-bold text-dark mb-0">
                                            {{ App\Models\Product::count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('shopping-list.index') }}" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-clipboard-list me-2"></i> View All Shopping Lists
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fa-solid fa-box me-2"></i> Browse Products
                            </a>
                            <a href="{{ route('shopping-list.create') }}" class="btn btn-success btn-lg">
                                <i class="fa-solid fa-plus me-2"></i> Create New Shopping List
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fa-solid fa-arrow-left me-2"></i> Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Welcome Guest -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg text-center">
                    <div class="card-body p-5">
                        <i class="fa-solid fa-robot fa-4x text-primary mb-4"></i>
                        <h2 class="fw-bold mb-3">Welcome to Shopping List App</h2>
                        <p class="text-muted mb-4">
                            {{ route('login') ? 'Please log in' : 'Please sign up' }} to start managing your shopping lists.
                        </p>
                        <div class="d-flex justify-content-center gap-3 flex-column sm:flex-row">
                            @if(route('login'))
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                    <i class="fa-solid fa-sign-in-alt me-2"></i>Log In
                                </a>
                            @endif
                            @if(App\Models\User::first() && route('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="fa-solid fa-user-plus me-2"></i>Create Account
                                </a>
                            @elseif(route('login'))
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fa-solid fa-arrow-left me-2"></i>Log In
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
