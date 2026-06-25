@extends('layouts.app')

@section('title', 'Home')
@section('content')
<div class="landing-container" style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">
    <h1 style="margin-bottom: 20px;">Shopping Lists</h1>
    <div class="flash-message" style="margin-bottom: 20px; padding: 15px; border-radius: 5px;">
        @if(session('success'))
            <div class="alert">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert">✗ {{ session('error') }}</div>
        @endif
    </div>
    
    <p style="margin-bottom: 30px; color: #666;">
        You have {{ $lists->count() }} shopping list{{ $lists->count() > 1 ? 's' : '' }} across all users
    </p>
    
    @if($lists->isEmpty())
        <p class="text-muted">No shopping lists yet. Create one from the login page.</p>
    @else
        <ul class="shopping-list-links">
            @foreach($lists as $list)
                <li style="margin-bottom: 8px;">
                    <a href="{{ route('admin.shopping-list.show', $list->id) }}"
                       style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 10px; background: #f8f9fa; border-radius: 5px; border-left: 4px solid {{ $this->getPriorityColor($list->priority); }}">
                        @if($list->is_completed)
                            <span class="badge badge-success" style="background: #27ae60; padding: 4px 8px; border-radius: 3px; font-size: 12px;">✓ Complete</span>
                        @else
                            <span style="font-size: 12px; padding: 2px 6px; border-radius: 3px; background: #e9ecef;">● {{ $list->priority }}</span>
                        @endif
                        <span>{{ $list->title }}</span>
                    </a>
                    @if($list->due_date)
                        <small style="color: #6c757d;">Due: {{ $list->due_date }}</small>
                    @endif
                </li>
            @endforeach
        </ul>
        
        <div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
                <a href="{{ route('admin.shopping-list.create') }}"
               class="btn btn-primary" 
               style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 5px;">
                + Create New Shopping List
            </a>
        </div>
    @endif
    
    <nav style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e9ecef;">
        <a href="{{ route('login') }}" 
            style="text-decoration: none; color: #6c757d; font-size: 14px;">
            Login to manage your lists
        </a>
    </nav>
</div>
@endsection
