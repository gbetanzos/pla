@extends('layouts.app')

@section('content')
<div class="shadow-sm border-0"
     style="padding: 30px; background: #f8f9fa; border-radius: 12px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">My Shopping Lists</h2>

<div class="d-flex gap-2">
            <a href="{{ route('shopping-list.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Create List
            </a>
            <a href="#" onclick="alert('Sorting feature coming soon')" class="btn btn-outline-primary">
                <i class="far fa-calendar-alt"></i>
            </a>
        </div>
    </div>

    <div class="shopping-lists-grid"
         style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px;">
        @foreach($lists as $list)
@php
    $listBgColor = $list->is_completed ? '#f8f9fa' : 'white';
    $priorityColor = $list->priority === 'high' ? '#dc3545' : ($list->priority === 'medium' ? '#ffc107' : '#28a745');
@endphp

            <a href="{{ route('shopping-lists.show', $list) }}"
               class="card shadow-sm border-0 h-100"
style="background: {{ $listBgColor }}; border-left: 8px solid {{ $priorityColor }}; transition: transform 0.2s ease; display: flex; flex-direction: column;">
                <div style="flex: 1; padding: 20px; position: relative;">
                    <h3 class="mb-2" style="font-size: 18px; line-height: 1.4;">
                        {{ $list->title }}
                    </h3>

                    @if($list->description)
                        <p class="text-muted"
                           style="font-size: 14px; margin: 0 0 12px 0; overflow: hidden; text-overflow: ellipsis;">
                            {{ $list->description }}
                        </p>
                    @endif

                    <div class="d-flex flex-wrap gap-2 mt-auto">
                        @if($list->priority)
                            <span class="badge rounded-pill"
                                  style="background: {{ $priorityColor }}; color: #212529;">
                                <i class="fas fa-flag"></i> {{ ucfirst($list->priority) }}
                            </span>
                        @endif

                        @if($list->is_completed)
                            <span class="badge bg-success rounded-pill">
                                <i class="fas fa-check-circle"></i> Complete
                            </span>
                        @elseif($list->items)
                            <span class="badge bg-secondary rounded-pill">
                                <i class="fas fa-list-ul"></i> {{ json_decode($list->items, true) ? count(json_decode($list->items, true)) : 0 }} items
                            </span>
                        @endif

                        @if($list->due_date)
                            @if($list->due_date->isPastNow())
                                <span class="badge bg-danger rounded-pill">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Due: {{ $list->due_date->format('M d, Y') }}
                                </span>
                            @else
                                <span class="badge bg-warning rounded-pill">
                                    <i class="far fa-calendar-alt"></i>
                                    Due: {{ $list->due_date->format('M d, Y') }}
                                </span>
                            @endif
                        @endif

                        <small class="text-muted" style="font-size: 11px;">
                            {{ $list->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>

                <div style="padding: 12px 20px; background: #f8f9fa; border-top: 1px solid #dee2e6; display: flex; gap: 10px;">
                    <span class="text-muted" style="font-size: 12px;">
                        @if($list->is_completed)
                            <i class="fas fa-check-circle text-success"></i>
                        @elseif($list->items)
                            <i class="fas fa-list-ul text-primary"></i>
                        @else
                            <i class="fas fa-list text-secondary"></i>
                        @endif
                    </span>
                </div>
            </a>
        @endforeach

        @if($lists->isEmpty())
            <div class="col-12" style="grid-column: 1 / -1;">
                <div class="text-center py-5"
                     style="border: 2px dashed #dee2e6; background: #fff; border-radius: 12px;">
                    <i class="fas fa-list-alt text-muted fa-4x mb-3"></i>
                    <h4 class="text-muted mb-2">No shopping lists yet</h4>
                    <p class="text-muted">Create your first list to get started!</p>
                    <a href="{{ route('shopping-list.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus"></i> Create List
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
