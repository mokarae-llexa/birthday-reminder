<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FriendController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::resource('friends', FriendController::class);
Route::get('/calendar', [FriendController::class, 'calendar'])->name('calendar');