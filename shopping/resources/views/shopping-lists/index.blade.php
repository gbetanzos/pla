@extends('layouts.app')

@section('content')
<div class="shadow-sm border-0 p-4" style="background: #f8f9fa; border-radius: 12px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">My Shopping Lists</h2>

        <div class="d-flex gap-2">
            <a href="{{ route('shopping-list.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i> Create List
            </a>
            <form method="GET" action="{{ route('shopping-lists.index') }}" class="d-flex align-items-center gap-2 mb-0">
                <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                    <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Newest</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>Priority</option>
                    <option value="due_date" {{ request('sort') == 'due_date' ? 'selected' : '' }}>Due Date</option>
                </select>
            </form>
        </div>
    </div>

    <div class="shopping-lists-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px;">
        @foreach($lists as $list)
            @php
                $isCompleted = $list->is_completed;
                $bgColor = $isCompleted ? '#f8f9fa' : 'white';
                $priorityColor = match($list->priority) {
                    'high' => '#dc3545',
                    'medium' => '#ffc107',
                    default => '#28a745',
                };
                
                $itemsCount = 0;
                if (!empty($list->items)) {
                    $decodedItems = json_decode($list->items, true);
                    $itemsCount = is_array($decodedItems) ? count($decodedItems) : 0;
                }
            @endphp

            <div class="card shadow-sm border-0 h-100" style="background: {{ $bgColor }}; border-left: 8px solid {{ $priorityColor }}; transition: transform 0.2s ease;">
                <div class="card-body p-4">
                    <h3 class="h5 mb-2 text-truncate">{{ $list->title }}</h3>

                    @if($list->description)
                        <p class="text-muted small mb-3 text-truncate" style="max-width: 100%;">
                            {{ $list->description }}
                        </p>
                    @endif

                    <div class="d-flex gap-2 mt-auto">
                        <a href="{{ route('shopping-lists.show', $list) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                            <i class="fas fa-eye me-1"></i> View
                        </a>
                        <form method="POST" action="{{ route('shopping-lists.destroy', $list) }}" data-confirm="true" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-footer bg-light border-top py-2 px-4">
                    <span class="text-muted" style="font-size: 12px;">
                        @if($isCompleted)
                            <i class="fas fa-check-circle text-success me-1"></i> Completed
                        @elseif($itemsCount > 0)
                            <i class="fas fa-list-ul text-primary me-1"></i> {{ $itemsCount }} Items
                        @else
                            <i class="fas fa-list text-secondary me-1"></i> Empty List
                        @endif
                    </span>
                </div>
            </div>
        @endforeach

        @if($lists->isEmpty())
            <div class="col-12">
                <div class="text-center py-5 border border-2 border-dashed rounded-3 bg-white">
                    <i class="fas fa-list-alt text-muted fa-3x mb-3"></i>
                    <h4 class="text-muted mb-2">No shopping lists yet</h4>
                    <p class="text-muted">Create your first list to get started!</p>
                    <a href="{{ route('shopping-list.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-1"></i> Create List
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection