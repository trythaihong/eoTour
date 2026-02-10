<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Gate;
// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tour/{tour}', [HomeController::class, 'showTour'])->name('tour.show');

// Authentication 
Auth::routes();

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/{tour}/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/{tour}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/history', [HomeController::class, 'bookingHistory'])->name('booking.history');
});



// Admin Routes 
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('tours', TourController::class);
    Route::resource('bookings', AdminBookingController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});
