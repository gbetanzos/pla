@extends('layouts.app')

@section('title', 'Home')
<div class="container mx-auto px-4 py-10 sm:px-6 lg:py-12">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Shopping Lists</h1>
        
        <div @if(session('success')) @error('success')class="alert alert-success dark:bg-green-900 dark:text-green-100 border-l-4 border-green-500"@endif @endif @if(session('error')) @error('error')class="alert alert-danger dark:bg-red-900 dark:text-red-100 border-l-4 border-red-500"@endif @endif>
            @if(session('success'))
                <div class="alert alert-success flex items-center gap-3 dark:bg-green-900 dark:text-green-100 border-l-4 border-green-500">
                    <i class="fas fa-check-circle text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger flex items-center gap-3 dark:bg-red-900 dark:text-red-100 border-l-4 border-red-500">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                    {{ session('error') }}
                </div>
            @endif
        </div>
        
        <p class="text-gray-600 dark:text-gray-400 mb-8">
            You have <strong>{{ $lists->count() }}</strong> shopping list{{ $lists->count() > 1 ? 's' : '' }} across all users
        </p>
        
        @if($lists->isEmpty())
            <p class="text-gray-500 dark:text-gray-500 mb-4">No shopping lists yet. Create one from the login page.</p>
        @else
            <div class="bg-white dark:bg-slate-800 shadow-md rounded-xl overflow-hidden">
                <ul class="divide-y divide-gray-100 dark:divide-slate-700">
                    @foreach($lists as $list)
                        <li class="py-4 flex items-center justify-between @if($list->is_completed) hover:bg-green-50 dark:hover:bg-green-900/20 @else hover:bg-gray-50 dark:hover:bg-slate-700 @endif">
                            <a href="{{ route('admin.shopping-list.show', $list->id) }}"
                               class="flex items-center gap-3 group"
                               aria-label="{{ $list->title }} {{ $list->is_completed ? '(completed)' : '('.$list->priority.')' }}">
                                @if($list->is_completed)
                                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                @else
                                    <span class={`w-3 h-3 rounded-full flex-shrink-0 @match($list->priority) { high => 'bg-red-500', medium => 'bg-yellow-500', low => 'bg-green-500' }`}></span>
                                @endif
                                <div>
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100 group-hover:underline">{{ $list->title }}</span>
                                    @if($list->is_completed)
                                        <span class="text-sm text-green-600 dark:text-green-400 ml-2">✓ Complete</span>
                                    @else
                                        <span class="text-xs text-gray-500 dark:text-gray-500">@match($list->priority) { high => 'High', medium => 'Medium', low => 'Low' } Priority</span>
                                    @endif
                                </div>
                            </a>
                            @if($list->due_date)
                                <span class="text-sm text-gray-500 dark:text-gray-500">@if(\Carbon\Carbon::parse($list->due_date)->isPast)
                                    <span class="text-red-500 dark:text-red-400">Overdue!</span>
                                @else
                                    Due: {{ \Carbon\Carbon::parse($list->due_date)->format('M d, Y') }}
                                @endif</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('admin.shopping-list.create') }}"
                   class="btn btn-primary inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-6 py-2 rounded-lg shadow-sm transition">
                    <i class="fas fa-plus"></i>
                    Create New Shopping List
                </a>
            </div>
        @endif
        
        <nav class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-700">
            <a href="{{ route('login') }}" 
               class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition"
               tabindex="-1" aria-label="Sign in link">
                Login to manage your lists
            </a>
        </nav>
    </div>
</div>
