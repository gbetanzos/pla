<?php

namespace App\Http\Controllers\Bp;

use App\Http\Controllers\Controller;
use App\Models\BloodPressure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BpController extends Controller
{
    public function index(Request $request): View
    {
        $bpRecords = BloodPressure::with('user')->latest()->get();
        $authUser = $request->user();
        return view('bp.index', compact('bpRecords', 'authUser'));
    }

    public function create(): View
    {
        return view('bp.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'systolic' => 'required|integer|min:80|max:250',
            'diastolic' => 'required|integer|min:60|max:120',
            'notes' => 'nullable|string|max:500',
        ]);

        BloodPressure::create([
            'user_id' => $request->user()->id,
            ...$validated,
        ]);

        return redirect()->route('bp.index')
            ->with('success', 'Blood pressure reading added successfully.');
    }

    public function show(BloodPressure $bp): View
    {
        return view('bp.show', compact('bp'));
    }

    public function edit(BloodPressure $bp): View
    {
        return view('bp.edit', compact('bp'));
    }

    public function update(Request $request, BloodPressure $bp): RedirectResponse
    {
        if ($request->user() !== $bp->user) {
            return redirect()->route('bp.index')
                ->with('error', 'You can only edit your own record.');
        }

        $validated = $request->validate([
            'systolic' => 'required|integer|min:80|max:250',
            'diastolic' => 'required|integer|min:60|max:120',
            'notes' => 'nullable|string|max:500',
        ]);

        $bp->update($validated);

        return redirect()->route('bp.index')
            ->with('success', 'Blood pressure reading updated successfully.');
    }

    public function destroy(BloodPressure $bp): RedirectResponse
    {
        if ($request->user() !== $bp->user) {
            return redirect()->route('bp.index')
                ->with('error', 'You can only delete your own record.');
        }

        $bp->delete();

        return redirect()->route('bp.index')
            ->with('success', 'Blood pressure reading deleted successfully.');
    }
}
