<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Garden;


class GardenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        Garden::create($validated);

        return redirect()->back()->with('success', 'Garden added successfully!');
    }

    public function destroy(Garden $garden)
    {
        $garden->delete();

        return redirect()->back()->with('success', 'Garden removed successfully!');
    }
}
