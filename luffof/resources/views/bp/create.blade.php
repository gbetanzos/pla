<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name') }} - Add Blood Pressure Reading</title>
    @vite(['resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="mx-auto max-w-lg w-full">
            <div class="mb-4">
                <a href="{{ route('bp.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">&larr; Back</a>
            </div>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Blood Pressure Reading
            </h2>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto mt-10">
        <form method="POST" action="{{ route('bp.store') }}">
            @csrf

            <div>
                <label for="systolic" class="block text-sm font-medium text-gray-700">
                    Systolic (mmHg)
                </label>
                <input
                    id="systolic"
                    name="systolic"
                    type="number"
                    value="{{ old('systolic') }}"
                    required
                    min="80"
                    max="250"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
                <p class="mt-1 text-sm text-gray-500">Normal: 90-120</p>
            </div>

            <div class="mt-4">
                <label for="diastolic" class="block text-sm font-medium text-gray-700">
                    Diastolic (mmHg)
                </label>
                <input
                    id="diastolic"
                    name="diastolic"
                    type="number"
                    value="{{ old('diastolic') }}"
                    required
                    min="60"
                    max="120"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
                <p class="mt-1 text-sm text-gray-500">Normal: 60-80</p>
            </div>

            <div class="mt-4">
                <label for="notes" class="block text-sm font-medium text-gray-700">
                    Notes (optional)
                </label>
                <input
                    id="notes"
                    name="notes"
                    type="text"
                    value="{{ old('notes') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium">
                    Add Reading
                </button>
            </div>
        </form>
    </div>
</body>
</html>
