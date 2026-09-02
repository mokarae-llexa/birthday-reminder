<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FriendController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::resource('friends', FriendController::class);
Route::get('/calendar', [FriendController::class, 'calendar'])->name('calendar');

use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});