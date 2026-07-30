<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Owner Registration Routes
    Route::get('/owner/register', [\App\Http\Controllers\OwnerController::class, 'create'])->name('owner.register');
    Route::post('/owner/register', [\App\Http\Controllers\OwnerController::class, 'store'])->name('owner.store');
});

require __DIR__.'/auth.php';
