<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name') }} - Blood Pressure Records</title>
    @vite(['resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col items-center py-8">
        <div class="container w-full max-w-4xl px-4">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-indigo-700 hover:text-indigo-900 mb-4 inline-block">
                ← Back to dashboard
            </a>
            
            <div class="text-center mb-8">
                @auth
                    <p class="text-2xl font-bold text-indigo-600 mb-2">
                        Welcome, {{ $authUser->name }}!
                    </p>
                    <p class="text-lg text-gray-700">
                        Add your blood pressure readings below
                    </p>
                @else
                    <p class="text-lg font-medium">
                        Sign in to start tracking
                    </p>
                @endauth
            </div>
            
            <div class="flex items-center justify-end mb-6">
                <a href="{{ route('bp.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-md font-medium shadow-md">
                    ✏️ Add Blood Pressure Reading
                </a>
            </div>

            <h2 class="text-xl font-semibold leading-tight text-gray-800 mb-6">
                Blood Pressure Records
            </h2>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="-m-1 flex flex-wrap" id="list-wrap">
                        @forelse($bpRecords as $record)
                            <div
                                class="m-1 bg-white border border-gray-200 rounded-lg hover:border-indigo-500 p-4 w-full sm:w-1/2 lg:w-1/3"
                            >
                                <div class="text-left">
                                    <h3 class="text-lg font-bold text-gray-900">
                                        {{ $record->systolic }}/{{ $record->diastolic }} <span class="text-sm text-gray-500">mmHg</span>
                                        <span class="text-sm text-gray-400">{{ $record->created_at->diffForHumans() }}</span>
                                    </h3>
                                    @if($record->notes)
                                        <p class="text-gray-600 mt-2 italic">"{{ Str::limit($record->notes, 60) }}"</p>
                                    @endif
                                    <div class="mt-3 text-xs text-gray-400">
                                        ID: {{ $record->id }}
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center justify-end space-x-2">
                                    <a
                                        href="{{ route('bp.show', $record) }}"
                                        class="text-blue-500 hover:text-blue-700 px-3 py-1 rounded"
                                    >
                                        View
                                    </a>
                                    <a
                                        href="{{ route('bp.edit', $record) }}"
                                        class="text-indigo-500 hover:text-indigo-700 p-2"
                                    >
                                        ✏️
                                    </a>
                                    <button
                                        data-clipboard-target="#record-desc-{{ $record->id }}"
                                        class="text-green-500 hover:text-green-700 p-2"
                                    >
                                        📋
                                    </button>
                                    <a
                                        href="{{ route('bp.destroy', $record) }}"
                                        method="delete"
                                        class="text-red-500 hover:text-red-700 p-2"
                                        onclick="event.preventDefault(); if(confirm('Delete this record?')) this.closest('form').submit();"
                                    >
                                        🗑️
                                    </a>
                                    <form method="POST" action="{{ route('bp.destroy', $record) }}" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="m-1 bg-white border border-gray-200 rounded-lg p-4 text-center">
                                <p class="text-gray-500">No blood pressure records yet. Add one above!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>