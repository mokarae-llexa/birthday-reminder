<?php

namespace App\Services;

use App\Models\BirthdayNotification;
use App\Models\Friend;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Logika inti pengingat ulang tahun.
 *
 * Dibuat sebagai service murni agar mudah di-unit-test dan dipakai
 * ulang oleh controller, API feed, dan artisan command.
 */
class BirthdayReminderService
{
    /**
     * Ulang tahun berikutnya (tahun berjalan atau tahun depan) untuk
     * sebuah tanggal lahir, dihitung dari $today (default: hari ini).
     *
     * 29 Februari pada tahun non-kabisat dirayakan pada 28 Februari.
     */
    public function nextOccurrence(Carbon $birthDate, ?Carbon $today = null): Carbon
    {
        $today = ($today ?? Carbon::today())->copy()->startOfDay();
        $month = $birthDate->month;
        $day = $birthDate->day;

        if ($month === 2 && $day === 29 && ! Carbon::create($today->year, 1, 1)->isLeapYear()) {
            $day = 28;
        }

        $candidate = Carbon::create($today->year, $month, $day)->startOfDay();

        if ($candidate->lt($today)) {
            $nextYear = $today->year + 1;
            $day = $birthDate->day;
            if ($month === 2 && $day === 29 && ! Carbon::create($nextYear, 1, 1)->isLeapYear()) {
                $day = 28;
            }
            $candidate = Carbon::create($nextYear, $month, $day)->startOfDay();
        }

        return $candidate;
    }

    /**
     * Daftar ulang tahun dalam $withinDays hari ke depan (termasuk hari ini).
     *
     * @param iterable<array|Friend> $friends
     * @return Collection<int, array{friend: Friend, date: Carbon, days_until: int, age_turning: int, bucket: string}>
     */
    public function upcoming(iterable $friends, ?Carbon $today = null, int $withinDays = 7): Collection
    {
        $today = ($today ?? Carbon::today())->copy()->startOfDay();

        $result = collect();

        foreach ($friends as $item) {
            $friend = $item instanceof Friend ? $item : new Friend(is_array($item) ? $item : []);
            $birthDate = $friend->birth_date ? Carbon::parse($friend->birth_date) : null;

            if (! $birthDate) {
                continue;
            }

            $date = $this->nextOccurrence($birthDate, $today);
            $daysUntil = (int) $today->diffInDays($date);

            if ($daysUntil > $withinDays) {
                continue;
            }

            $result->push([
                'friend' => $friend,
                'date' => $date,
                'days_until' => $daysUntil,
                'age_turning' => $date->year - $birthDate->year,
                'bucket' => match (true) {
                    $daysUntil === 0 => 'today',
                    $daysUntil === 1 => 'tomorrow',
                    default => 'upcoming',
                },
            ]);
        }

        return $result->sortBy('days_until')->values();
    }

    /**
     * Sinkronkan notifikasi ulang tahun untuk user ke tabel
     * birthday_notifications (idempoten per user+teman+tipe+tanggal).
     */
    public function refreshUserNotifications(User $user, ?Carbon $today = null, int $withinDays = 7): Collection
    {
        $today = ($today ?? Carbon::today())->copy()->startOfDay();
        $items = $this->upcoming(Friend::query()->whereNotNull('birth_date')->get(), $today, $withinDays);

        foreach ($items as $item) {
            /** @var Friend $friend */
            $friend = $item['friend'];
            $dateString = $item['date']->toDateString();

            // whereDate dipakai agar idempoten di semua driver DB
            // (kolom date bisa tersimpan sebagai datetime string di SQLite).
            $exists = BirthdayNotification::where('user_id', $user->id)
                ->where('friend_id', $friend->id)
                ->where('type', $item['bucket'])
                ->whereDate('notify_date', $dateString)
                ->exists();

            if (! $exists) {
                BirthdayNotification::create([
                    'user_id' => $user->id,
                    'friend_id' => $friend->id,
                    'type' => $item['bucket'],
                    'notify_date' => $dateString,
                    'title' => $this->titleFor($friend->name, $item['bucket'], $item['age_turning']),
                    'message' => $this->messageFor($friend->name, $item['bucket'], $item['age_turning'], $item['days_until']),
                    'meta' => ['days_until' => $item['days_until'], 'age_turning' => $item['age_turning']],
                ]);
            }
        }

        return $items;
    }

    public function unreadCount(User $user): int
    {
        return BirthdayNotification::where('user_id', $user->id)->whereNull('read_at')->count();
    }

    public function titleFor(string $name, string $bucket, int $age): string
    {
        return match ($bucket) {
            'today' => "Hari ini ulang tahun {$name} yang ke-{$age}! 🎂",
            'tomorrow' => "Besok ulang tahun {$name}! 🎈",
            default => "Ulang tahun {$name} segera tiba 🎁",
        };
    }

    public function messageFor(string $name, string $bucket, int $age, int $daysUntil): string
    {
        return match ($bucket) {
            'today' => "Jangan lupa kirim ucapan — {$name} genap berusia {$age} tahun hari ini.",
            'tomorrow' => "Siapkan kado atau pesan spesial untuk {$name} yang berusia {$age} tahun besok.",
            default => "{$name} akan berusia {$age} tahun dalam {$daysUntil} hari. Kirim ucapan lebih awal yuk.",
        };
    }
}
