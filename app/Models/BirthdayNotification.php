<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BirthdayNotification extends Model
{
    protected $fillable = [
        'user_id',
        'friend_id',
        'type',
        'title',
        'message',
        'notify_date',
        'read_at',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'notify_date' => 'date',
            'read_at' => 'datetime',
            'meta' => 'array',
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

    public function getIsReadAttribute(): bool
    {
        return $this->read_at !== null;
    }
}
