@extends('layouts.app')

@section('title', 'Home')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-dark mb-2">
                    <i class="fa-solid fa-list-check me-2 text-primary"></i>Shopping Lists
                </h1>
                <p class="text-muted">{{ $lists->count() }} shopping list{{ $lists->count() > 1 ? 's' : '' }}</p>
            </div>

            <!-- Alerts -->
            @if(session('success') || session('error'))
            <div class="alert {{ session('error') ? 'alert-danger' : 'alert-success' }} alert-dismissible fade show" role="alert">
                <i class="fa-solid {{ session('error') ? 'fa-exclamation-circle' : 'fa-check-circle' }} me-2"></i>
                {{ session('success') ?? session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Empty State -->
            @if($lists->isEmpty())
                <div class="card shadow-sm border-0 text-center p-5">
                    <i class="fa-solid fa-clipboard-list fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted mb-2">No shopping lists yet</h4>
                    <p class="text-muted mb-4">Create one from the shopping list page or login to get started.</p>
                    <a href="{{ route('shopping-list.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-1"></i>Create New List
                    </a>
                </div>
            @else
                <!-- Lists Grid -->
                <div class="row g-3">
                    @foreach($lists as $list)
                        <div class="col-12">
                            <div class="card shadow-sm border-0 {{ $list->is_completed ? 'border-start-4 border-success bg-light' : '' }} p-3">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div class="flex-grow-1">
                                        <a href="{{ route('shopping-lists.show', $list->id) }}" class="text-decoration-none">
                                            <h5 class="card-title fw-bold mb-1 {{ $list->is_completed ? 'text-success' : 'text-dark' }}">
                                                <i class="fa-solid fa-clipboard text-success me-2"></i>{{ $list->title }}
                                            </h5>
                                            <p class="text-muted mb-0">
                                                @if($list->is_completed)
                                                    <i class="fa-solid fa-check me-1"></i>Complete
                                                @else
                                                    <span class="badge {{ ($list->priority == 'high') ? 'bg-danger' : (($list->priority == 'medium') ? 'bg-warning text-dark' : 'bg-success') }} ms-1">{{ ucfirst($list->priority) }} Priority</span>
                                                @endif
                                            </p>
                                            @if($list->description)
                                                <p class="text-muted mt-2 mb-0 text-secondary">{{ $list->description }}</p>
                                            @endif
                                        </a>
                                    </div>
                                    <i class="fa-solid fa-{{ $list->is_completed ? 'check-circle' : 'clock' }} fa-2x text-muted flex-shrink-0"></i>
                                </div>
                                @if($list->due_date)
                                <div class="mt-2 text-end text-muted">
                                    @if(\Carbon\Carbon::parse($list->due_date)->isPast)
                                        <span class="text-danger">Overdue!</span>
                                    @else
                                        <i class="fa-solid fa-calendar me-1"></i>Due: {{ \Carbon\Carbon::parse($list->due_date)->format('M d, Y') }}
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Create Button -->
                <div class="text-center mt-4">
                    <a href="{{ route('shopping-list.create') }}" class="btn btn-primary btn-lg">
                        <i class="fa-solid fa-plus me-2"></i>Create New Shopping List
                    </a>
                </div>

                <!-- Login Link -->
                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        <span class="text-muted">Not logged in?</span> <span class="text-primary">Login</span> <span class="text-muted">to manage lists</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
