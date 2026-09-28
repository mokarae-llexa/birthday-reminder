<?php

namespace App\Events;

use App\Models\Greeting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Disiarkan setiap ada ucapan baru yang dikirim ke teman, sehingga
 * riwayat ucapan di browser bisa diperbarui realtime (polling +
 * websocket bila driver broadcast mendukungnya).
 */
class GreetingSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Greeting $greeting,
    ) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel('user.'.$this->greeting->user_id)];
    }

    public function broadcastAs(): string
    {
        return 'greeting.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->greeting->id,
            'friend_id' => $this->greeting->friend_id,
            'message' => $this->greeting->message,
            'channel' => $this->greeting->channel,
            'created_at' => $this->greeting->created_at?->toDateTimeString(),
        ];
    }
}
