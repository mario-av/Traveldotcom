<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::get('/', [MainController::class, 'index'])->name('main.index');


Route::get('/vacation/{vacation}', [VacationController::class, 'show'])->name('vacation.show');


Route::get('/image/{id}', [ImageController::class, 'view'])->name('image.view');
Route::get('/photo/{id}', [ImageController::class, 'photo'])->name('photo.view');



Auth::routes(['verify' => true]);



Route::middleware('auth')->group(function () {
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/edit', [HomeController::class, 'edit'])->name('home.edit');
    Route::put('/home/update', [HomeController::class, 'update'])->name('home.update');
    Route::post('/theme/accent', [ThemeController::class, 'setAccent'])->name('theme.accent');
});



Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');

    
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/review/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/review/{review}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
});



Route::resource('vacation', VacationController::class)->except(['show']);
Route::resource('user', UserController::class);
Route::resource('category', \App\Http\Controllers\CategoryController::class);



Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::post('/booking/{booking}/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');

    
    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
    Route::post('/review/{review}/approve', [ReviewController::class, 'approve'])->name('review.approve');

    
    Route::post('/user/{user}/verify', [UserController::class, 'verifyEmail'])->name('user.verify');
    Route::post('/user/{user}/role', [UserController::class, 'updateRole'])->name('user.role');

    
    Route::delete('/vacation/delete/group', [VacationController::class, 'deleteGroup'])->name('vacation.delete.group');
    Route::delete('/user/delete/group', [UserController::class, 'deleteGroup'])->name('user.delete.group');
});
