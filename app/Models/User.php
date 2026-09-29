<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'status',
        'password',
        'avatar',
        'birth_date',
    ];

    public function greetings(): HasMany
    {
        return $this->hasMany(Greeting::class)->latest();
    }

    public function linkedFriends(): HasMany
    {
        return $this->hasMany(Friend::class, 'linked_user_id');
    }

    public function birthdayNotifications(): HasMany
    {
        return $this->hasMany(BirthdayNotification::class)->latest();
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://') || str_starts_with($this->avatar, 'data:image/')) {
                return $this->avatar;
            }
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->avatar)) {
                return asset('storage/' . $this->avatar);
            }
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=FFE1DD&color=C55F4E&size=64&bold=true';
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
