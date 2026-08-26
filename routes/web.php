<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PhotoOfFieldController;
use App\Http\Controllers\SparringInviteController;
use App\Http\Controllers\SparringPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $fields = \App\Models\Field::where('status', 'available')
        ->with(['photos', 'reviews'])
        ->latest()
        ->take(3)
        ->get();

    return view('welcome', compact('fields'));
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Public Routes
Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');
Route::get('/fields/{field}', [FieldController::class, 'show'])->name('fields.show');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Owner Registration (tidak memakai middleware owner: harus dapat diakses user biasa)
    Route::get('/owner/register', [\App\Http\Controllers\OwnerController::class, 'create'])->name('owner.register');
    Route::post('/owner/register', [\App\Http\Controllers\OwnerController::class, 'store'])->name('owner.store');

    // Owner workspace: memerlukan profil pemilik lapangan.
    Route::middleware('owner')->group(function () {
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

        // Owner: Dashboard (ringkasan venue)
        Route::get('/owner/dashboard', OwnerDashboardController::class)->name('owner.dashboard');

        // Owner: Profil Bisnis
        Route::get('/owner/profile', [\App\Http\Controllers\OwnerController::class, 'edit'])->name('owner.profile.edit');
        Route::put('/owner/profile', [\App\Http\Controllers\OwnerController::class, 'update'])->name('owner.profile.update');

        // Owner: Pesanan masuk (dedicated page)
        Route::get('/owner/bookings', [BookingController::class, 'ownerBookings'])->name('owner.bookings');
        Route::patch('/owner/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('owner.bookings.confirm');
        Route::patch('/owner/bookings/{booking}/complete', [BookingController::class, 'complete'])->name('owner.bookings.complete');
    });

    // Renter: Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{schedule}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Renter: Payment
    Route::get('/bookings/{booking}/pay', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/bookings/{booking}/pay', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

    // Sparring Matchmaking
    Route::get('/sparring', [SparringPostController::class, 'index'])->name('sparring.index');
    Route::get('/sparring/create', [SparringPostController::class, 'create'])->name('sparring.create');
    Route::post('/sparring', [SparringPostController::class, 'store'])->name('sparring.store');
    Route::get('/sparring/{sparringPost}', [SparringPostController::class, 'show'])->name('sparring.show');
    Route::post('/sparring/{sparringPost}/invite', [SparringInviteController::class, 'store'])->name('sparring.invites.store');
});

require __DIR__.'/auth.php';
