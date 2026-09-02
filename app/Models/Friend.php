<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Friend extends Model
{
    protected $table = 'friends';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'birth_date',
        'notes',
        'avatar',
    ];

    protected $appends = ['avatar_url'];

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