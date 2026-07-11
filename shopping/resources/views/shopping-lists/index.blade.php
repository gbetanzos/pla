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

    <div class="shopping-lists-grid"
         style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px;">
        @foreach($lists as $list)
        @php
            $listBgColor = $list->is_completed ? '#f8f9fa' : 'white';
            $priorityColor = $list->priority === 'high' ? '#dc3545' : ($list->priority === 'medium' ? '#ffc107' : '#28a745');
            $indexItems = is_array($list->items) ? $list->items : (is_string($list->items) ? json_decode($list->items, true) : []);
            if (!is_array($indexItems)) { $indexItems = []; }
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

                                        <div class="d-flex gap-2 mt-2">
                                            <a href="{{ route('shopping-lists.show', $list) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                                <i class="fas fa-eye"></i> View
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

                <div style="padding: 12px 20px; background: #f8f9fa; border-top: 1px solid #dee2e6; display: flex; gap: 10px;">
                    <span class="text-muted" style="font-size: 12px;">
                        @if($list->is_completed)
                            <i class="fas fa-check-circle text-success"></i>
                    @elseif(!empty($indexItems))
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
