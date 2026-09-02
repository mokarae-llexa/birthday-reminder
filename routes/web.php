<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\FriendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();


// Semua halaman yang membutuhkan login
Route::middleware('auth')->group(function () {

    // Home
    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    // Data Teman
    Route::resource('friends', FriendController::class);

    // Calendar
    Route::get('/calendar', [FriendController::class, 'calendar'])
        ->name('calendar');

    // Notification
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    // Profile
    Route::get('/profil', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::get('/profil/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profil/update', [ProfileController::class, 'update'])
        ->name('profile.update');
});