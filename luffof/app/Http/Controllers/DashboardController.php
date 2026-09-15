<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/**
 * BP dashboard for the authenticated user only.
 *
 * Returns $dates[] (sorted date labels), $stats[metric][min/avg/max], and
 * $chart[metric][label] = max metric value on that label.
 */
class DashboardController extends Controller
{
    public function index(): View
    {
        $user    = auth()->user();
        $range   = request('range');
        $metrics = ['systolic', 'diastolic'];

        $bp = ($range === 'weekly')
            ? $user->bloodPressures()
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->get()
            : $user->bloodPressures()->whereMonth('created_at', now()->month)->get();

        $stats = [];
        foreach ($metrics as $metric) {
            if ($bp->isEmpty()) {
                $stats[$metric] = [0, 0, 0];
            } else {
                $values       = $bp->pluck($metric);
                $stats[$metric] = [$values->min(), $values->avg(), $values->max()];
            }
        }

        $chart = [];
        $dates = [];
        foreach ($bp->groupBy('created_at') as $rows) {
            $label = $rows->first()->created_at->format('d M');
            $dates[] = $label;
            foreach ($metrics as $metric) {
                $chart[$metric][$label] = $rows->max($metric);
            }
        }

        usort($dates, fn ($a, $b) => strcmp($a, $b));

        return view('dashboard', [
            'bpCount' => $user->bloodPressures()->count(),
            'stats'   => $stats,
            'range'   => $range,
            'chart'   => $chart,
            'dates'   => $dates,
        ]);
    }
}
