<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Greeting extends Model
{
    public const CHANNELS = ['inapp', 'whatsapp', 'email'];

    protected $fillable = [
        'user_id',
        'friend_id',
        'message',
        'channel',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function friend(): BelongsTo
    {
        return $this->belongsTo(Friend::class);
    }

    /**
     * Deep-link WhatsApp ke nomor teman dengan pesan terisi otomatis.
     * Asumsi nomor Indonesia: awalan 0 diubah menjadi 62.
     */
    public function whatsappUrl(): ?string
    {
        $phone = $this->friend?->phone;

        if (! $phone) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        if ($digits === '' || $digits === null) {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        return 'https://wa.me/'.$digits.'?text='.urlencode($this->message);
    }
}
