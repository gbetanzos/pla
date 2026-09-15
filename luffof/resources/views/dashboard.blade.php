@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Dashboard</h2>
        <div class="badge bg-secondary fs-6">Total BP Records: {{ $bpCount }}</div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex flex-wrap justify-content-between gap-2 align-items-center">
            <span class="fw-semibold">BP Trends</span>
            <div class="btn-group btn-group-sm">
                <a href="{{ route('dashboard') }}" class="btn {{ request('range') !== 'weekly' ? 'btn-primary' : 'btn-outline-primary' }}">Monthly</a>
                <a href="{{ route('dashboard', ['range' => 'weekly']) }}" class="btn {{ request('range') === 'weekly' ? 'btn-primary' : 'btn-outline-primary' }}">Weekly</a>
            </div>
        </div>
        <div class="card-body">
            @if($chart && count($chart) > 0)
                <div class="row g-0">
                    <div class="col-md-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <div style="position: relative; height: 260px;">
                                    <canvas id="bp-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6"><div class="card mb-2 border-0 shadow-sm text-center h-100">
                                        <div class="card-body py-2">
                                            <div class="text-muted small text-uppercase">Systolic (mmHg)</div>
                                            <div class="row g-2 mt-1">
                                                <div><div class="fw-bold">{{ number_format($stats['systolic'][0], 0) }}</div><div class="text-muted small">Min</div></div>
                                                <div><div class="fw-bold">{{ number_format($stats['systolic'][1], 1) }}</div><div class="text-muted small">Avg</div></div>
                                                <div><div class="fw-bold">{{ number_format($stats['systolic'][2], 0) }}</div><div class="text-muted small">Max</div></div>
                                            </div>
                                        </div>
                                    </div></div>
                                    <div class="col-6"><div class="card mb-2 border-0 shadow-sm text-center h-100">
                                        <div class="card-body py-2">
                                            <div class="text-muted small text-uppercase">Diastolic (mmHg)</div>
                                            <div class="row g-2 mt-1">
                                                <div><div class="fw-bold">{{ number_format($stats['diastolic'][0], 0) }}</div><div class="text-muted small">Min</div></div>
                                                <div><div class="fw-bold">{{ number_format($stats['diastolic'][1], 1) }}</div><div class="text-muted small">Avg</div></div>
                                                <div><div class="fw-bold">{{ number_format($stats['diastolic'][2], 0) }}</div><div class="text-muted small">Max</div></div>
                                            </div>
                                        </div>
                                    </div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    No blood pressure readings in the selected period.
                </div>
            @endif
        </div>
    </div>

    <a href="{{ route('bp.create') }}" class="btn btn-primary mb-3 text-center block">Add New Reading</a>

    @yield('main')

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        const labels   = {!! json_encode($dates) !!};
        const chart = {!! json_encode($chart) !!};

        // chart[systolic][label] === max systolic for that label.
        const systolic = {};
        const diastolic = {};
        Object.keys(chart.systolic).forEach(function (label) {
            systolic[label] = Number(chart.systolic[label]);
        });
        Object.keys(chart.diastolic).forEach(function (label) {
            diastolic[label] = Number(chart.diastolic[label]);
        });

        new Chart(document.getElementById('bp-chart'), {
            type: 'line',
            data: {
                labels: labels.map(function (d) {
                    return d ? 'M ' + d : null;
                }),
                datasets: [
                    {
                        label: 'Systolic',
                        data: labels.map(function (d) {
                            return systolic[d] !== undefined ? systolic[d] : null;
                        }),
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13,108,253,0.1)',
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#0d6efd',
                        borderWidth: 2,
                        fill: 'origin',
                    },
                    Object.keys(diastolic).length > 0 && {
                        label: 'Diastolic',
                        data: diastolic,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220,53,69,0.1)',
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#dc3545',
                        borderWidth: 2,
                        fill: 'origin',
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.06)',
                        },
                        title: {
                            display: true,
                            text: 'mmHg',
                        },
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.06)',
                        },
                    },
                },
            },
        });
    </script>
@endpush
