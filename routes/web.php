<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\GreetingController;
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

    Route::get('/friends/search/database', [FriendController::class, 'searchDatabase'])->name('friends.search-database');
    Route::get('/friends/requests', [FriendController::class, 'inbox'])->name('friends.requests');
    Route::post('/friends/{friend}/accept', [FriendController::class, 'accept'])->name('friends.accept');
    Route::post('/friends/{friend}/decline', [FriendController::class, 'decline'])->name('friends.decline');

    Route::resource('friends', FriendController::class)->except(['show']);
    
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    Route::get('/notifications', [NotificationController::class, 'index']) ->name('notifications.index');
    Route::get('/api/notifications/feed', [NotificationController::class, 'feed'])->name('api.notifications.feed');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    Route::get('/friends/{friend}/greetings', [GreetingController::class, 'index'])->name('greetings.index');
    Route::post('/friends/{friend}/greetings', [GreetingController::class, 'store'])->name('greetings.store');
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

});