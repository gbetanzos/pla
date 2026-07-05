@extends('layouts.app')

@section('title', 'Login')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">
        <!-- Hero -->
        <div class="text-center mb-5">
            <div class="mb-3">
                <i class="fa-solid fa-basket-shopping fa-4x text-primary"></i>
            </div>
            <h1 class="display-6 fw-bold text-dark mb-2">Shopping Lists</h1>
            <p class="text-muted fs-5">Organize your groceries, one list at a time.</p>
        </div>

        <!-- Feature Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <i class="fa-solid fa-clipboard-list fa-2x text-primary mb-3"></i>
                    <h5 class="fw-bold">Create Lists</h5>
                    <p class="text-muted mb-0 small">Build shopping lists with titles, priorities, and due dates.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <i class="fa-solid fa-cart-plus fa-2x text-success mb-3"></i>
                    <h5 class="fw-bold">Add Products</h5>
                    <p class="text-muted mb-0 small">Pick items from your product catalog or add new ones.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <i class="fa-solid fa-circle-check fa-2x text-warning mb-3"></i>
                    <h5 class="fw-bold">Check Off Items</h5>
                    <p class="text-muted mb-0 small">Mark items as you shop and track your progress.</p>
                </div>
            </div>
        </div>

        <!-- CTA Buttons -->
        <div class="card border-0 shadow-sm p-4 text-center bg-light rounded-3">
            <h5 class="fw-bold mb-1">Ready to start?</h5>
            <p class="text-muted mb-4 small">Sign in to manage your lists or jump right in.</p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('shopping-list.create') }}"
                   class="btn btn-primary btn-lg px-4">
                    <i class="fa-solid fa-plus me-2"></i>Create Your First List
                </a>
                <a href="{{ route('landing') }}"
                   class="btn btn-outline-secondary btn-lg px-4">
                    <i class="fa-solid fa-list me-2"></i>View All Lists
                </a>
            </div>

            <!-- Login / Register -->
            <hr class="my-4">
            <p class="text-muted small mb-3">Already have an account?</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-right-to-bracket me-1"></i>Log In
                </a>
                @if(route('register'))
                <a href="{{ route('register') }}" class="btn btn-outline-success">
                    <i class="fa-solid fa-user-plus me-1"></i>Sign Up
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
