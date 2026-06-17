<x-guest-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $bp->systolic }}/{{ $bp->diastolic }} mmHg - {{ $bp->created_at->format('M d, Y') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded-lg shadow">
        <dl class="space-y-6">
            <div>
                <dt class="text-sm font-medium text-gray-500">Systolic</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $bp->systolic }} mmHg</dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500">Diastolic</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $bp->diastolic }} mmHg</dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500">Blood Pressure (mmHg)</dt>
                <dd class="mt-1 text-lg font-medium text-gray-900">{{ $bp->systolic }}/{{ $bp->diastolic }}</dd>
            </div>

            @if($bp->notes)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                    <dd class="mt-1 text-gray-600 italic">{{ $bp->notes }}</dd>
                </div>
            @endif

            <div class="text-xs text-gray-400 pt-4 border-t">
                Created: {{ $bp->created_at->format('F d, Y at g:i A') }}<br>
                Updated: {{ $bp->updated_at->format('F d, Y at g:i A') }}
            </div>

            <div class="mt-6 pt-6 border-t flex items-center justify-end space-x-4">
                <div class="text-right">
                    <a href="{{ route('bp.edit', $bp) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                        ✏️ Edit
                    </a>
                </div>
                <div class="text-right">
                    <a href="{{ route('bp.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">
                        ← Back to all records
                    </a>
                </div>
                <form method="DELETE" action="{{ route('bp.destroy', $bp) }}" class="text-right">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium" onclick="event.preventDefault(); this.closest('form').submit();">
                        🗑️ Delete
                    </button>
                </form>
            </div>
        </dl>
    </div>
</x-guest-layout>
