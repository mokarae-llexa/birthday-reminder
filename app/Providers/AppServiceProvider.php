<?php

namespace App\Providers;

use App\Models\BirthdayNotification;
use App\Models\Friend;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        User::observe(UserObserver::class);

        View::composer('layouts.sidebar', function ($view) {
            $view->with('totalFriendsCount', Friend::count());

            $unread = 0;
            if (Auth::check()) {
                $unread = BirthdayNotification::where('user_id', Auth::id())
                    ->whereNull('read_at')
                    ->count();
            }
            $view->with('unreadNotificationsCount', $unread);

            $pendingRequests = 0;
            if (Auth::check()) {
                $pendingRequests = Friend::where('linked_user_id', Auth::id())
                    ->where('request_status', 'pending')
                    ->count();
            }
            $view->with('pendingFriendRequestsCount', $pendingRequests);
        });
    }
}
