@extends('layouts.app')

@section('content')
<h2 class="mb-4">Create New Shopping List</h2>
<form action="{{ route('shopping-list.store') }}" method="POST"
      class="card shadow-sm border-0"
      style="padding: 30px; background: #f8f9fa;">
    @csrf

    <div class="mb-3">
        <label for="title" class="form-label fw-bold">Title <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-lg"
               id="title" name="title" required placeholder="e.g., Weekly Groceries">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control"
                  id="description" name="description"
                  rows="2"
                  placeholder="Optional notes about this list..."></textarea>
    </div>

    <div class="row align-items-end">
        <div class="col-md-4 mb-3">
            <label for="priority" class="form-label fw-bold">Priority <span class="text-danger">*</span></label>
            <select class="form-select" id="priority" name="priority" required>
                <option value="">Select Priority</option>
                <option value="high" class="text-danger fw-bold">High (Critical)</option>
                <option value="medium" class="text-warning">Medium</option>
                <option value="low" class="text-success">Low</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control"
                   id="due_date" name="due_date">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-success w-100">Create List</button>
        </div>
    </div>
</form>

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    {{ session('error') }}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@endsection
