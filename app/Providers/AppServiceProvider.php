<?php

namespace App\Providers;

<<<<<<< HEAD
use Illuminate\Support\Facades\URL;
=======
use App\Models\BirthdayNotification;
use App\Models\Friend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
>>>>>>> 5bb8283c118804bb0a38c27628232af1eb3b2393
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
<<<<<<< HEAD
        
=======
        View::composer('layouts.sidebar', function ($view) {
            $view->with('totalFriendsCount', Friend::count());

            $unread = 0;
            if (Auth::check()) {
                $unread = BirthdayNotification::where('user_id', Auth::id())
                    ->whereNull('read_at')
                    ->count();
            }
            $view->with('unreadNotificationsCount', $unread);
        });
>>>>>>> 5bb8283c118804bb0a38c27628232af1eb3b2393
    }
}
