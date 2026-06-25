@extends('layouts.app')

@section('title', 'Shopping Lists')
@section('content')
<div class="admin-container" style="max-width: 900px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>My Shopping Lists</h1>
            <a href="{{ route('admin.shopping-list.create') }}"
           class="btn btn-primary" 
           style="display: inline-flex; gap: 8px; padding: 10px 20px;">
            + Create List
        </a>
    </div>
    
    <div class="flash-message">
        @if(session('success'))
            <div class="alert-success" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 10px; margin-bottom: 15px;">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-danger" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 10px; margin-bottom: 15px;">
                ✗ {{ session('error') }}
            </div>
        @endif
    </div>
    
    @if($lists->isEmpty())
        <div style="padding: 40px 20px; background: #f8f9fa; border-radius: 5px; text-align: center;">
            <p style="margin-bottom: 20px; color: #6c757d;">No shopping lists yet</p>
        <a href="{{ route('admin.shopping-list.create') }}"
               style="color: #007bff; text-decoration: underline;">Create your first list</a>
        </div>
    @else
        <div class="shopping-lists-grid">
            @foreach($lists as $list)
                <a href="{{ route('admin.shopping-list.show', $list->id) }}" 
                   class="shopping-list-card"
                   style="display: block; padding: 20px; background: #f8f9fa; border-radius: 5px; transition: transform 0.2s; border-left: 4px solid {{ $this->getPriorityColor($list->priority); }} {{ $list->is_completed ? '#27ae60' : 'transparent' }}, position: relative;">
                    
                    <h3 style="margin: 0 0 8px 0; font-size: 18px;">
                        {{ $this->truncateString($list->title, 60) }}
                    </h3>
                    
                    @if($list->description)
                        <p style="margin: 0; color: #6c757d; font-size: 14px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $this->truncateString($list->description, 80) }}
                        </p>
                    @endif
                    
                    <div style="margin-top: 15px; display: flex; gap: 10px; font-size: 12px; color: #6c757d;">
                        @if($list->priority)
                            <span class="priority-badge" style="display: inline-block; padding: 3px 8px; border-radius: 12px; background: {{ $this->getPriorityColor($list->priority); color: white; }};">
                                {{ $this->getPriorityName($list->priority) }}
                            </span>
                        @endif
                        
                        @if($list->is_completed)
                            <span class="badge badge-success" style="background: #27ae60; padding: 3px 8px; border-radius: 3px; font-size: 11px;">
                                ✓ Complete
                            </span>
                        @elseif($list->items)
                            <span style="background: #e9ecef; padding: 3px 8px; border-radius: 3px; font-size: 11px;">
                                {{ json_decode($list->items, true) ? count(json_decode($list->items, true)) : 0 }} items
                            </span>
                        @endif
                        
                        @if($list->due_date)
                            <span class="badge badge-warning" style="background: #ffc107; color: #212529; padding: 3px 8px; border-radius: 3px; font-size: 11px;">
                                📅 {{ $list->due_date }}
                            </span>
                        @endif
                        
                        <small style="color: #adb5bd;">{{ $list->created_at->diffForHumans() }}</small>
                    </div>
                    
                    @if(strlen($list->title) > 80)
                        <p style="margin-top: 10px; font-size: 12px; color: #888; overflow: hidden; text-overflow: ellipsis;">
                            {{ $list->title }}
                        </p>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
@section('scripts')
<script>
    window.getPriorityColor = function(priority) {
        return {'1': '#dc3545', '2': '#ffc107', '3': '#28a745'}[priority] || '#6c757d';
    };

    window.getPriorityName = function(priority) {
        return {'1': 'High Priority', '2': 'Medium Priority', '3': 'Low Priority'}[priority] || 'Normal Priority';
    };

    window.truncateString = function(string, maxLength) {
        return string.length > maxLength ? string.substring(0, maxLength - 3) + '...' : string;
    };

    window.truncateStringPriority = function(string, maxLength) {
        return string.length > maxLength ? string.substring(0, maxLength - 3) + '...' : string;
    };

    window.truncateDescription = function(string, maxLength) {
        return string.length > maxLength ? string.substring(0, maxLength - 3) + '...' : string;
    };

    window.countItems = function(items) {
        return items ? items.reduce((sum, item) => sum + (item.checked ? 0 : 1), 0) : 0;
    };
</script>
@endsection