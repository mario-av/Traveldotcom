<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Anonymous Access)
|--------------------------------------------------------------------------
*/

// Landing page with vacation listings
Route::get('/', [MainController::class, 'index'])->name('landing');

// Vacation detail (public view)
Route::get('/vacation/{vacation}', [VacationController::class, 'show'])->name('vacation.show');

// Image serving
Route::get('/image/{path}', [ImageController::class, 'show'])->where('path', '.*')->name('image.show');

/*
|--------------------------------------------------------------------------
| Guest Routes (Not Logged In)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Logged In, Any Verification Status)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Email verification
    Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.resend');
});

/*
|--------------------------------------------------------------------------
| Verified User Routes (Email Verified)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // User dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile/edit', [HomeController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [HomeController::class, 'update'])->name('profile.update');

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/vacation/{vacation}/book', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    // Reviews (requires booking - checked in controller)
    Route::post('/vacation/{vacation}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::put('/review/{review}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Vacation management
    Route::get('/vacations', [VacationController::class, 'index'])->name('vacation.index');
    Route::get('/vacation/create', [VacationController::class, 'create'])->name('vacation.create');
    Route::post('/vacation', [VacationController::class, 'store'])->name('vacation.store');
    Route::get('/vacation/{vacation}/edit', [VacationController::class, 'edit'])->name('vacation.edit');
    Route::put('/vacation/{vacation}', [VacationController::class, 'update'])->name('vacation.update');
    Route::delete('/vacation/{vacation}', [VacationController::class, 'destroy'])->name('vacation.destroy');

    // User management
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/users/bulk-delete', [UserController::class, 'bulkDelete'])->name('user.bulkDelete');

    // Booking management
    Route::post('/booking/{booking}/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');

    // Review management
    Route::post('/review/{review}/approve', [ReviewController::class, 'approve'])->name('review.approve');
});
