<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Friend;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = Carbon::today();
        
        // Fetch all friends
        $friends = Friend::all();
        
        // Map friends with days_left and next_birthday
        $friends = $friends->map(function ($friend) use ($today) {
            $birthDate = Carbon::parse($friend->birth_date);
            $nextBirthday = Carbon::parse($friend->birth_date)->year($today->year);
            
            if ($nextBirthday->isPast()) {
                $nextBirthday->addYear();
            }
            
            $friend->days_left = (int) $today->diffInDays($nextBirthday, false);
            return $friend;
        });
        
        // Sort friends by days_left ascending
        $sortedFriends = $friends->sortBy('days_left')->values();
        
        // Today's birthdays (days_left == 0)
        $todayBirthdays = $sortedFriends->filter(function ($friend) {
            return $friend->days_left == 0;
        });
        
        // If there is a birthday today, use the first one as the highlight
        // Otherwise, use the closest upcoming birthday as the highlight
        $highlightFriend = $todayBirthdays->first() ?? $sortedFriends->first();
        
        // Upcoming birthdays (excluding today's birthdays if there is one, or just the rest)
        $upcomingFriends = $sortedFriends;
        if ($highlightFriend) {
            $upcomingFriends = $sortedFriends->filter(function ($friend) use ($highlightFriend) {
                return $friend->id !== $highlightFriend->id;
            });
        }
        
        // Limit upcoming to 3
        $upcomingFriends = $upcomingFriends->take(3)->values();
        
        // Count total friends for the sidebar badge
        $totalFriendsCount = Friend::count();
        
        return view('home', compact('highlightFriend', 'upcomingFriends', 'totalFriendsCount'));
    }
}
