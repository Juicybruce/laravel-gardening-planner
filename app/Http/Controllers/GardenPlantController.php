<?php

namespace App\Http\Controllers;

use App\Models\GardenPlant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GardenPlantController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'garden_id' => 'required|exists:gardens,id',
            'plant_id' => 'required|exists:plants,id',
            'planting_date' => 'required|date',
        ]);

        GardenPlant::create($validated);

        return redirect()->back()->with('success', 'Plant added successfully!');
    }

    public function destroy(GardenPlant $gardenPlant)
    {
        // Optional: Add authorization check
        // $this->authorize('delete', $gardenPlant);

        $gardenPlant->delete();

        return redirect()->back()->with('success', 'Plant removed successfully!');
    }
}
