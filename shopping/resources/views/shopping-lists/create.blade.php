@extends('layouts.app')

@section('content')
<h2>Create New Shopping List</h2>
<form action="{{ route('shopping-lists.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Title *</label>
        <input type="text" name="title" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description"></textarea>
    </div>
    <div class="form-group">
        <label>Priority *</label>
        <select name="priority" required>
            <option value="high">High</option>
            <option value="medium">Medium</option>
            <option value="low">Low</option>
        </select>
    </div>
    <div class="form-group">
        <label>Due Date</label>
        <input type="date" name="due_date">
    </div>
    <div class="form-group">
        <label>Notes</label>
        <textarea name="notes"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Create List</button>
</form>
@endsection
