<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CalendarController;

use Illuminate\Http\JsonResponse;


Route::get('/health', static function (): JsonResponse {
    return response()->json(['status' => 'ok']);
});

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('friends', FriendController::class);
    
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    Route::get('/notifications', [NotificationController::class, 'index']) ->name('notifications.index');
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

});