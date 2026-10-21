<?php

namespace App\Providers;

use App\Models\BirthdayNotification;
use App\Models\Friend;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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
            $totalFriends = 0;
            if (Auth::check()) {
                $totalFriends = Friend::where('created_by', Auth::id())
                    ->where(function ($q) {
                        $q->whereNull('request_status')->orWhere('request_status', 'accepted');
                    })
                    ->count();
            }
            $view->with('totalFriendsCount', $totalFriends);

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

        // HTTPS hanya dipaksa kalau APP_URL memakai https (server/tunnel).
        // Di laptop, APP_URL=http://127.0.0.1:8000 -> tidak dipaksa.
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}