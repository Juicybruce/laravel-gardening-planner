<?php

namespace Database\Seeders;

use App\Models\Plant;
use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    public function run()
    {
        $plants = [
            [
                'name' => 'Tomato',
                'description' => 'Classic garden tomato, great for salads and cooking',
                'days_to_harvest' => 80,
                'typical_lifespan_days' => 180,
                'fertilizing_frequency_days' => 14,
            ],
            [
                'name' => 'Lettuce',
                'description' => 'Quick-growing leafy green',
                'days_to_harvest' => 45,
                'typical_lifespan_days' => 60,
                'fertilizing_frequency_days' => 21,
            ],
            [
                'name' => 'Carrot',
                'description' => 'Sweet root vegetable',
                'days_to_harvest' => 70,
                'typical_lifespan_days' => 70,
                'fertilizing_frequency_days' => 21,
            ],
            [
                'name' => 'Bell Pepper',
                'description' => 'Crisp, colorful peppers',
                'days_to_harvest' => 90,
                'typical_lifespan_days' => 150,
                'fertilizing_frequency_days' => 14,
            ],
            [
                'name' => 'Basil',
                'description' => 'Aromatic herb perfect for cooking',
                'days_to_harvest' => 30,
                'typical_lifespan_days' => 120,
                'fertilizing_frequency_days' => 30,
            ],
        ];

        foreach ($plants as $plant) {
            Plant::create($plant);
        }
    }
}
