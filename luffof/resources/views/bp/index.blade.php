@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">← Back to dashboard</a>
    <a href="{{ route('bp.create') }}" class="btn btn-primary">Add Blood Pressure Reading</a>
</div>
<h2 class="mb-4">Blood Pressure Records</h2>

@if($bpRecords->isEmpty())
    <div class="alert alert-info">No blood pressure records yet. Add one above!</div>
@else
    <div class="row">
        @foreach($bpRecords as $record)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $record->systolic }}/{{ $record->diastolic }} <small class="text-muted">mmHg</small></h5>
                            <p class="card-text"><small class="text-muted">{{ $record->created_at->diffForHumans() }}</small></p>
                            @if($record->notes)
                                <p class="card-text"><em>{{ Str::limit($record->notes,60) }}</em></p>
                            @endif
                        </div>
                        <p class="card-text"><small class="text-muted">ID: {{ $record->id }}</small></p>
                        <div class="btn-group" role="group">
                            <a href="{{ route('bp.show', $record) }}" class="btn btn-outline-primary btn-sm">View</a>
                            <a href="{{ route('bp.edit', $record) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                            <form action="{{ route('bp.destroy', $record) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this record?');">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection