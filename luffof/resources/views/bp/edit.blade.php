@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">Edit Blood Pressure Reading</div>
            <div class="card-body">
                <form method="POST" action="{{ route('bp.update', $bp) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label for="systolic" class="form-label">Systolic (mmHg)</label>
                        <input type="number" name="systolic" id="systolic" required min="80" max="250" class="form-control" value="{{ old('systolic', $bp->systolic) }}">
                        <p class="form-text text-muted">Normal: 90‑120</p>
                    </div>
                    <div class="mb-3">
                        <label for="diastolic" class="form-label">Diastolic (mmHg)</label>
                        <input type="number" name="diastolic" id="diastolic" required min="60" max="120" class="form-control" value="{{ old('diastolic', $bp->diastolic) }}">
                        <p class="form-text text-muted">Normal: 60‑80</p>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes (optional)</label>
                        <input type="text" name="notes" id="notes" class="form-control" value="{{ old('notes', $bp->notes) }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection