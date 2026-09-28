<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Disiarkan saat ada ulang tahun hari ini. Dengan driver "log" event
 * tercatat di log; dengan Reverb/Pusher event sampai ke browser
 * lewat channel privat user.{id} secara realtime.
 */
class BirthdayToday implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $userId,
        public array $birthdays,
    ) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel('user.'.$this->userId)];
    }

    public function broadcastAs(): string
    {
        return 'birthday.today';
    }

    public function broadcastWith(): array
    {
        return [
            'count' => count($this->birthdays),
            'birthdays' => $this->birthdays,
        ];
    }
}
