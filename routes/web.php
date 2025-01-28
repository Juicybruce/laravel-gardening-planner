<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GardenController;
use App\Http\Controllers\GardenPlantController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware('auth')->group(function () {
    Route::post('/gardenplants', [GardenPlantController::class, 'store'])->name('gardenplants.store');
    Route::delete('/gardenplants/{gardenPlant}', [GardenPlantController::class, 'destroy'])->name('gardenplants.destroy');

    Route::post('/garden', [GardenController::class, 'store'])->name('garden.store');
    Route::delete('/garden/{garden}', [GardenController::class, 'destroy'])->name('garden.destroy');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
