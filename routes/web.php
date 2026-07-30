<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PhotoOfFieldController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public Routes
Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');
Route::get('/fields/{field}', [FieldController::class, 'show'])->name('fields.show');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Owner Registration
    Route::get('/owner/register', [\App\Http\Controllers\OwnerController::class, 'create'])->name('owner.register');
    Route::post('/owner/register', [\App\Http\Controllers\OwnerController::class, 'store'])->name('owner.store');

    // Owner: Field Management
    Route::get('/owner/fields', [FieldController::class, 'ownerIndex'])->name('owner.fields.index');
    Route::get('/owner/fields/create', [FieldController::class, 'create'])->name('owner.fields.create');
    Route::post('/owner/fields', [FieldController::class, 'store'])->name('owner.fields.store');
    Route::get('/owner/fields/{field}/edit', [FieldController::class, 'edit'])->name('owner.fields.edit');
    Route::put('/owner/fields/{field}', [FieldController::class, 'update'])->name('owner.fields.update');
    Route::delete('/owner/fields/{field}', [FieldController::class, 'destroy'])->name('owner.fields.destroy');
    Route::put('/owner/field-photos/{photoOfField}', [PhotoOfFieldController::class, 'update'])->name('owner.field-photos.update');
    Route::delete('/owner/field-photos/{photoOfField}', [PhotoOfFieldController::class, 'destroy'])->name('owner.field-photos.destroy');

    // Owner: Schedule Management
    Route::get('/owner/fields/{field}/schedules', [ScheduleController::class, 'index'])->name('owner.schedules.index');
    Route::post('/owner/fields/{field}/schedules', [ScheduleController::class, 'store'])->name('owner.schedules.store');
    Route::delete('/owner/fields/{field}/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('owner.schedules.destroy');

    // Owner: Incoming Bookings
    Route::get('/owner/bookings', [BookingController::class, 'ownerBookings'])->name('owner.bookings');
    Route::patch('/owner/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('owner.bookings.confirm');

    // Renter: Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{schedule}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

    // Renter: Payment
    Route::get('/bookings/{booking}/pay', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/bookings/{booking}/pay', [PaymentController::class, 'store'])->name('payments.store');
});

require __DIR__.'/auth.php';
