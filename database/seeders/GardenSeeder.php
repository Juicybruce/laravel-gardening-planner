<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Garden;
use App\Models\Plant;
use Illuminate\Database\Seeder;

class GardenSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'test@example.com')->first();

        // Create two gardens
        $vegetableGarden = Garden::create([
            'user_id' => $user->id,
            'name' => 'Vegetable Patch',
            'description' => 'Main vegetable garden in the backyard',
        ]);

        $herbGarden = Garden::create([
            'user_id' => $user->id,
            'name' => 'Herb Garden',
            'description' => 'Small herb garden near the kitchen',
        ]);

        // Add plants to vegetable garden
        $plants = Plant::all();

        // Tomatoes planted a month ago
        $vegetableGarden->plants()->attach($plants->where('name', 'Tomato')->first()->id, [
            'planting_date' => now()->subMonth(),
            'last_fertilized_at' => now()->subWeeks(1),
        ]);

        // Lettuce planted two weeks ago
        $vegetableGarden->plants()->attach($plants->where('name', 'Lettuce')->first()->id, [
            'planting_date' => now()->subWeeks(2),
            'last_fertilized_at' => now()->subWeeks(1),
        ]);

        // Carrots planted 6 weeks ago
        $vegetableGarden->plants()->attach($plants->where('name', 'Carrot')->first()->id, [
            'planting_date' => now()->subWeeks(6),
            'last_fertilized_at' => now()->subWeeks(2),
        ]);

        // Basil in herb garden
        $herbGarden->plants()->attach($plants->where('name', 'Basil')->first()->id, [
            'planting_date' => now()->subWeeks(3),
            'last_fertilized_at' => now()->subWeeks(1),
        ]);
    }
}
