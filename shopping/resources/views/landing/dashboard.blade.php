@extends('layouts.app')

@section('content')
@if(auth()->check())
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-user-circle me-2"></i>
                        <h4 class="mb-0">{{ auth()->user()->name }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <i class="fa-solid fa-list-ul fa-2x mb-2"></i>
                                    <h6 class="text-muted mb-1">Shopping Lists</h6>
                                    <h2 class="display-6 fw-bold text-primary">
                                        {{ auth()->user()->shoppingLists()->count() }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <i class="fa-solid fa-check fa-2x mb-2"></i>
                                    <h6 class="text-muted mb-1">Active Items</h6>
                                    <h2 class="display-6 fw-bold text-success">
                                        {{ auth()->user()->shoppingLists()->where('is_completed', false)->pluck('items')->flatten()->where('checked', false)->count() }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <i class="fa-solid fa-boxes-stacked fa-2x mb-2"></i>
                                    <h6 class="text-muted mb-1">Products</h6>
                                    <h2 class="display-6 fw-bold text-info">
                                        {{ App\Models\Product::count() }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fa-solid fa-arrow-right-long me-1"></i>
                                        Quick Links
                                    </h5>
                                </div>
                                <div class="card-body p-3">
                                    <a href="{{ route('shopping-list') }}" class="btn btn-primary me-2">
                                        <i class="fa-solid fa-clipboard-list me-1"></i> View All Shopping Lists
                                    </a>
                                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                        <i class="fa-solid fa-box me-1"></i> Browse Products
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 text-center p-5">
                <i class="fa-solid fa-robot fa-4x text-primary mb-3"></i>
                <h2 class="fw-bold mb-3">Welcome to Shopping List App</h2>
                <p class="text-muted mb-4">
                    Please {{ route('login') ? 'log in' : 'sign up' }} to get started with your shopping lists.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                        <i class="fa-solid fa-sign-in-alt me-2"></i>Log In
                    </a>
                    <a href="{{ App\Models\User::first() ? route('register') : route('login') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fa-solid fa-user-plus me-2"></i>Create Account
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
