@extends('layouts.app')

@section('content')
<h2>Edit Shopping List</h2>
<form action="{{ route('shopping-lists.update', $list) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Title *</label>
        <input type="text" name="title" value="{{ $list->title }}" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description">{{ $list->description }}</textarea>
    </div>
    <div class="form-group">
        <label>Priority *</label>
        <select name="priority" required>
            <option value="">None</option>
            <option value="high" {{ old('priority', $list->priority) === 'high' ? 'selected' : '' }}>High</option>
            <option value="medium" {{ old('priority', $list->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="low" {{ old('priority', $list->priority) === 'low' ? 'selected' : '' }}>Low</option>
        </select>
    </div>
    <div class="form-group">
        <label>Due Date</label>
        <input type="date" name="due_date" value="{{ $list->due_date ? $list->due_date->format('Y-m-d') : '' }}">
    </div>
    <div class="form-group">
        <label>Notes</label>
        <textarea name="notes">{{ $list->notes }}</textarea>
    </div>
    <div class="form-group">
        <label>Items</label>
        <div id="items-container"></div>
        <input type="hidden" name="items[]" value="{{ $list->items ? (json_decode($list->items, true) ?? []) : [] }}">
    </div>
    <button type="submit" class="btn btn-success">Update List</button>
    <a href="{{ route('shopping-lists.index') }}" class="btn btn-primary" style="margin-left: 10px;">Cancel</a>
</form>

<script>
    @if($list->items && json_decode($list->items, true) !== false)
        @foreach(json_decode($list->items, true) ?? [] as $index => $item)
            @if($item['product_id'])
                <div style="display: flex; align-items: center; margin: 5px 0; background: #f8f9fa; padding: 5px;">
                    <input type="checkbox" style="margin-right: 10px;" {{ $item['checked'] ? 'checked' : '' }}>
                    <span>{{ $item['name'] }}</span>
                    <a href="{{ route('shopping-lists.destroy', $list) }}" style="margin-left: 15px;" onclick="return confirm('Also remove this item?')">×</a>
                </div>
            @endif
        @endforeach
    @endif
    document.getElementById('items-container').innerHTML = `
        <div id="item-drop" style="padding: 20px; border: 2px dashed #ccc; border-radius: 4px; text-align: center; cursor: pointer;" onclick="document.getElementById('p1').click()">
            Click to check boxes below
        </div>
        <div style="margin-top: 10px; color: #666;">Select any item below to add it to this list</div>
    `;
</script>
@endsection
