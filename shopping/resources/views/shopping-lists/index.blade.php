@extends('layouts.app')

@section('content')
<h2>My Shopping Lists</h2>
<div class="items-list">
    @foreach($lists as $list)
        <div class="items-list-item priority-{{ strtolower($list->priority) }}">
            <input type="checkbox" class="items-list-item-checkbox" id="l{{ $list->id }}" {{ $list->completed ? 'checked' : '' }}>
            <span class="items-list-item-title">
                <a href="{{ route('shopping-list.show', $list) }}">
                    <strong>{{ $list->title }}</strong>
                </a>
                @if($list->priority) <small><em>P: {{ ucfirst($list->priority) }}</em></small> @endif
                @if($list->due_date) <br><small><em>Due: {{ $list->due_date->format('M d, Y') }}</em></small> @endif
            </span>
            <div style="margin-top: 8px;">
                <a href="{{ route('shopping-list.edit', $list) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('shopping-list.destroy', $list) }}" class="btn btn-danger">Delete</a>
            </div>
        </div>
    @endforeach
    @if($lists->isEmpty())
        <p>No shopping lists yet. Create your first one!</p>
    @endif
</div>
@endsection
