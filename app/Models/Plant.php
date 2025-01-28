<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $fillable = [
        'name',
        'description',
        'days_to_harvest',
        'typical_lifespan_days',
        'fertilizing_frequency_days',
    ];

    public function gardens()
    {
        return $this->belongsToMany(Garden::class, 'garden_plants')
            ->withPivot(['planting_date', 'last_fertilized_at'])
            ->withTimestamps();
    }
}
