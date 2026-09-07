@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">View Blood Pressure Reading</div>
            <div class="card-body">
                <p><strong>Systolic:</strong> {{ $bp->systolic }} mmHg</p>
                <p><strong>Diastolic:</strong> {{ $bp->diastolic }} mmHg</p>
                <p><strong>Reading:</strong> {{ $bp->systolic }}/{{ $bp->diastolic }} mmHg</p>
                @if($bp->notes)
                    <p><strong>Notes:</strong> {{ $bp->notes }}</p>
                @endif
                <p class="text-muted"><small>Created: {{ $bp->created_at->format('F d, Y &g:i A') }}<br>Updated: {{ $bp->updated_at->format('F d, Y &g:i A') }}</small></p>
                <div class="btn-group" role="group">
                    <a href="{{ route('bp.edit', $bp) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                    <form action="{{ route('bp.destroy', $bp) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this record?');">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection