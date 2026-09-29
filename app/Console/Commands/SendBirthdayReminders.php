<?php

namespace App\Console\Commands;

use App\Events\BirthdayToday;
use App\Models\User;
use App\Services\BirthdayReminderService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendBirthdayReminders extends Command
{
    protected $signature = 'birthdays:notify {--days=7 : Jangkauan hari ke depan yang disinkronkan}';

    protected $description = 'Sinkronkan notifikasi ulang tahun semua user dan siarkan event realtime';

    public function handle(BirthdayReminderService $service): int
    {
        $today = Carbon::today();
        $withinDays = max(0, (int) $this->option('days'));

        $users = User::all();
        $totalToday = 0;

        foreach ($users as $user) {
            $items = $service->refreshUserNotifications($user, $today, $withinDays);

            $todayItems = $items->where('bucket', 'today')->values()->map(fn (array $item) => [
                'friend_id' => $item['friend']->id,
                'name' => $item['friend']->name,
                'age_turning' => $item['age_turning'],
                'avatar_url' => $item['friend']->avatar_url,
            ])->all();

            if ($todayItems !== []) {
                BirthdayToday::dispatch($user->id, $todayItems);
                $totalToday += count($todayItems);
            }
        }

        $this->info("Notifikasi disinkronkan untuk {$users->count()} user; {$totalToday} ulang tahun hari ini.");

        return self::SUCCESS;
    }
}
