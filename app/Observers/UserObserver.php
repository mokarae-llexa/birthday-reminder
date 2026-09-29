<?php

namespace App\Observers;

use App\Models\Friend;
use App\Models\User;

class UserObserver
{
    public function updated(User $user): void
    {
        if (!$user->wasChanged(['name', 'email', 'birth_date', 'avatar'])) {
            return;
        }

        $oldAvatar = $user->getOriginal('avatar');
        $freshUser = $user->refresh();

        Friend::where('linked_user_id', $user->id)
            ->get()
            ->each(function (Friend $friend) use ($freshUser, $oldAvatar) {
                $friend->syncFromUser($freshUser, $oldAvatar);
            });
    }
}
