<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $gardens = $user->gardens()
            ->with(['plants' => function ($query) {
                $query->select('plants.*')
                      ->withPivot(['id', 'planting_date', 'last_fertilized_at']);
            }])
            ->get();

    $gardenSummary = [
        'total_gardens' => $gardens->count(),
        'total_plants' => $gardens->sum(function ($garden) {
            return $garden->plants->count();
        }),
    ];

    return Inertia::render('Dashboard', [
        'gardens' => $gardens,
        'summary' => $gardenSummary,
        'plants' => Plant::all(),
    ]);
    }
}
