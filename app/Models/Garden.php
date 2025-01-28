<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Garden extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    /**
     * The user this garden belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gardenPlants(): HasMany
    {
        return $this->hasMany(GardenPlant::class);
    }

    public function plants()
    {
        return $this->belongsToMany(Plant::class, 'garden_plants')
            ->withPivot(['planting_date', 'last_fertilized_at'])
            ->withTimestamps();
    }
}
