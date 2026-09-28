<?php

namespace App\Http\Controllers;

use App\Models\BirthdayNotification;
use App\Services\BirthdayReminderService;
use App\Traits\MessageResponser;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use MessageResponser;

    public function index(BirthdayReminderService $service)
    {
        $user = auth()->user();
        $service->refreshUserNotifications($user);

        $notifications = BirthdayNotification::with('friend')
            ->where('user_id', $user->id)
            ->orderByRaw('read_at IS NULL DESC')
            ->orderBy('notify_date')
            ->limit(50)
            ->get();

        $upcoming = $service->upcoming(
            \App\Models\Friend::query()->whereNotNull('birth_date')->get(),
            \Carbon\Carbon::today(),
            30
        );

        return view('notifications.index', [
            'notifications' => $notifications,
            'upcomingFriends' => $upcoming,
            'unreadCount' => $service->unreadCount($user),
        ]);
    }

    /**
     * Feed JSON untuk polling realtime di browser (dipanggil tiap N detik).
     */
    public function feed(BirthdayReminderService $service)
    {
        $user = auth()->user();
        $service->refreshUserNotifications($user);

        $notifications = BirthdayNotification::with('friend')
            ->where('user_id', $user->id)
            ->orderByRaw('read_at IS NULL DESC')
            ->orderBy('notify_date')
            ->limit(20)
            ->get()
            ->map(fn (BirthdayNotification $n) => [
                'id' => $n->id,
                'type' => $n->type,
                'title' => $n->title,
                'message' => $n->message,
                'notify_date' => $n->notify_date->toDateString(),
                'read_at' => $n->read_at?->toDateTimeString(),
                'created_at' => $n->created_at?->toDateTimeString(),
                'friend' => [
                    'id' => $n->friend->id,
                    'name' => $n->friend->name,
                    'phone' => $n->friend->phone,
                    'email' => $n->friend->email,
                    'avatar_url' => $n->friend->avatar_url,
                ],
            ]);

        return response()->json([
            'unread_count' => $service->unreadCount($user),
            'notifications' => $notifications,
        ]);
    }

    public function markRead(Request $request, BirthdayNotification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['read_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'id' => $notification->id]);
        }

        return back()->with('success', $this->successMessage('dibaca', 'Notifikasi'));
    }

    public function markAllRead(Request $request, BirthdayReminderService $service)
    {
        BirthdayNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'unread_count' => 0]);
        }

        return back()->with('success', $this->successMessage('dibaca', 'Semua notifikasi'));
    }
}
