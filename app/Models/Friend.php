<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Friend extends Model
{
    protected $table = 'friends';

    protected $fillable = [
        'linked_user_id',
        'created_by',
        'request_status',
        'name',
        'phone',
        'email',
        'birth_date',
        'notes',
        'avatar',
    ];

    protected $appends = ['avatar_url', 'is_linked'];

    public function linkedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'linked_user_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function greetings(): HasMany
    {
        return $this->hasMany(Greeting::class)->latest();
    }

    public function birthdayNotifications(): HasMany
    {
        return $this->hasMany(BirthdayNotification::class)->latest();
    }

    public function getIsLinkedAttribute(): bool
    {
        return !is_null($this->linked_user_id);
    }

    public function isPending(): bool
    {
        return $this->request_status === 'pending';
    }

    public function isAccepted(): bool
    {
        return is_null($this->request_status) || $this->request_status === 'accepted';
    }

    public function getDisplayNameAttribute(): ?string
    {
        return $this->linkedUser?->name ?? $this->getAttribute('name');
    }

    public function getDisplayEmailAttribute(): ?string
    {
        return $this->linkedUser?->email ?? $this->getAttribute('email');
    }

    public function getDisplayBirthDateAttribute(): ?string
    {
        $birthDate = $this->linkedUser?->birth_date ?? $this->getAttribute('birth_date');

        return $birthDate ? (string) $birthDate : null;
    }

    public function getDisplayAvatarUrlAttribute(): string
    {
        if ($this->linkedUser) {
            return $this->linkedUser->avatar_url;
        }

        return $this->avatar_url;
    }

    public function syncFromUser(User $user, ?string $oldUserAvatar = null): static
    {
        $this->linked_user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->birth_date = $user->birth_date ? (string) $user->birth_date : $this->birth_date;

        $currentAvatar = $this->getAttributes()['avatar'] ?? null;
        $newUserAvatar = $user->getAttributes()['avatar'] ?? null;

        if ($this->shouldFollowAvatar($currentAvatar, $oldUserAvatar)) {
            $this->avatar = $newUserAvatar;
        }

        if ($this->exists && $this->isDirty()) {
            $this->save();
        }

        return $this;
    }

    private function shouldFollowAvatar(?string $currentAvatar, ?string $oldUserAvatar): bool
    {
        if (empty($currentAvatar) || str_contains($currentAvatar, 'ui-avatars.com')) {
            return true;
        }

        if ($oldUserAvatar !== null && $currentAvatar === $oldUserAvatar) {
            return true;
        }

        return false;
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://') || str_starts_with($this->avatar, 'data:image/')) {
                return $this->avatar;
            }
            if (Storage::disk('public')->exists($this->avatar)) {
                return asset('storage/' . $this->avatar);
            }
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=FFE1DD&color=C55F4E&size=160&bold=true';
    }
}
