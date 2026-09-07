@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Dashboard</h2>
    <div class="badge bg-secondary fs-6">Total BP Records: {{ $bpCount }}</div>
</div>

<div class="row">
    <div class="col-md-12">
        <a href="{{ route('bp.index') }}" class="btn btn-primary mb-3">View All Records</a>
    </div>
</div>

@yield('main')

@endsection