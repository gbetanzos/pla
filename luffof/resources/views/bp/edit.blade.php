<x-guest-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Blood Pressure Reading
            </h2>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto mt-10">
        <form method="POST" action="{{ route('bp.update', $bp) }}">
            @csrf
            @method('PATCH')

            <div>
                <label for="systolic" class="block text-sm font-medium text-gray-700">
                    Systolic (mmHg)
                </label>
                <input
                    id="systolic"
                    name="systolic"
                    type="number"
                    value="{{ old('systolic', $bp->systolic) }}"
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
                    value="{{ old('diastolic', $bp->diastolic) }}"
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
                    value="{{ old('notes', $bp->notes ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-primary-button>
                    Update Reading
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
