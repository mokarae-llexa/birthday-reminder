<?php

namespace App\Http\Controllers;

use App\Events\GreetingSent;
use App\Models\Friend;
use App\Models\Greeting;
use App\Traits\MessageResponser;
use Illuminate\Http\Request;

class GreetingController extends Controller
{
    use MessageResponser;

    /**
     * Riwayat ucapan milik user untuk seorang teman (JSON, untuk thread realtime di modal).
     */
    public function index(Friend $friend)
    {
        $greetings = Greeting::with('user:id,name')
            ->where('user_id', auth()->id())
            ->where('friend_id', $friend->id)
            ->latest()
            ->limit(20)
            ->get()
            ->map(fn (Greeting $g) => [
                'id' => $g->id,
                'message' => $g->message,
                'channel' => $g->channel,
                'sender' => $g->user->name,
                'created_at' => $g->created_at?->toDateTimeString(),
                'whatsapp_url' => $g->channel === 'whatsapp' ? $g->whatsappUrl() : null,
            ]);

        return response()->json(['greetings' => $greetings]);
    }

    /**
     * Kirim ucapan ke teman (in-app tersimpan di DB; whatsapp/email
     * dibuka via deep-link di browser setelah tersimpan).
     */
    public function store(Request $request, Friend $friend)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'channel' => 'required|string|in:'.implode(',', Greeting::CHANNELS),
        ]);

        $greeting = Greeting::create([
            'user_id' => auth()->id(),
            'friend_id' => $friend->id,
            'message' => $validated['message'],
            'channel' => $validated['channel'],
        ]);

        GreetingSent::dispatch($greeting);

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'greeting' => [
                    'id' => $greeting->id,
                    'message' => $greeting->message,
                    'channel' => $greeting->channel,
                    'created_at' => $greeting->created_at?->toDateTimeString(),
                ],
                'whatsapp_url' => $greeting->channel === 'whatsapp' ? $greeting->whatsappUrl() : null,
                'mailto_url' => $greeting->channel === 'email' && $friend->email
                    ? 'mailto:'.$friend->email.'?subject='.urlencode("Selamat ulang tahun, {$friend->name}! 🎂").'&body='.urlencode($greeting->message)
                    : null,
            ], 201);
        }

        return back()->with('success', $this->successMessage('dikirim', 'Ucapan ulang tahun'));
    }
}
