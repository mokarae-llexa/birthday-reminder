<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $today = Carbon::today();
        
        $friends = Friend::all();
        
        $friends = $friends->map(function ($friend) use ($today) {
            $birthDate = Carbon::parse($friend->birth_date);
            $nextBirthday = Carbon::parse($friend->birth_date)->year($today->year);
            
            if ($nextBirthday->isPast()) {
                $nextBirthday->addYear();
            }
            
            $friend->days_left = (int) $today->diffInDays($nextBirthday, false);
            return $friend;
        });
        
        $sortedFriends = $friends->sortBy('days_left')->values();
        
        $todayBirthdays = $sortedFriends->filter(function ($friend) {
            return $friend->days_left == 0;
        });
        
        $highlightFriend = $todayBirthdays->first() ?? $sortedFriends->first();
        
        $upcomingFriends = $sortedFriends;
        if ($highlightFriend) {
            $upcomingFriends = $sortedFriends->filter(function ($friend) use ($highlightFriend) {
                return $friend->id !== $highlightFriend->id;
            });
        }
        
        $upcomingFriends = $upcomingFriends->take(3)->values();
        
        $totalFriendsCount = Friend::count();
        
        return view('home', compact('highlightFriend', 'upcomingFriends', 'totalFriendsCount'));
    }
}
