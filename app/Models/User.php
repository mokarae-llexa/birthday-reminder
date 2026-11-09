<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
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
        'class_name',
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
    public function setClassNameAttribute($value): void
    {
        $value = trim((string) $value);

        $this->attributes['class_name'] = $value === ''
            ? null
            : mb_strtoupper(preg_replace('/\s*-\s*/', '-', $value));
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
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=FCE4E6&color=B95569&size=64&bold=true';
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
            'birth_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::updated(function (User $user) {
            $changes = [];

            if ($user->wasChanged('birth_date')) {
                $changes['birth_date'] = $user->birth_date;
            }

            if ($user->wasChanged('class_name')) {
                $changes['class_name'] = $user->class_name;
            }
            if (($changes)) {
                Friend::where('linked_user_id', $user->id)
                    ->update($changes);
                    
            }
        });
    }
}
