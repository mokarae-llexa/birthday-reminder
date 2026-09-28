<?php

namespace Tests\Unit;

use App\Models\Friend;
use App\Models\User;
use App\Services\BirthdayReminderService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BirthdayReminderServiceTest extends TestCase
{
    use RefreshDatabase;

    private BirthdayReminderService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BirthdayReminderService();
    }

    private function friend(string $name, string $birthDate): Friend
    {
        return new Friend(['name' => $name, 'birth_date' => $birthDate]);
    }

    public function test_next_occurrence_later_this_year(): void
    {
        $today = Carbon::create(2026, 5, 1);
        $next = $this->service->nextOccurrence(Carbon::parse('1990-08-17'), $today);

        $this->assertEquals('2026-08-17', $next->toDateString());
    }

    public function test_next_occurrence_today_stays_this_year(): void
    {
        $today = Carbon::create(2026, 5, 1);
        $next = $this->service->nextOccurrence(Carbon::parse('1990-05-01'), $today);

        $this->assertEquals('2026-05-01', $next->toDateString());
    }

    public function test_next_occurrence_yesterday_rolls_to_next_year(): void
    {
        $today = Carbon::create(2026, 5, 1);
        $next = $this->service->nextOccurrence(Carbon::parse('1990-04-30'), $today);

        $this->assertEquals('2027-04-30', $next->toDateString());
    }

    public function test_feb_29_celebrated_on_feb_28_in_non_leap_year(): void
    {
        $today = Carbon::create(2025, 2, 27); // 2025 bukan kabisat
        $next = $this->service->nextOccurrence(Carbon::parse('2000-02-29'), $today);

        $this->assertEquals('2025-02-28', $next->toDateString());
    }

    public function test_feb_29_kept_in_leap_year(): void
    {
        $today = Carbon::create(2024, 2, 27); // 2024 kabisat
        $next = $this->service->nextOccurrence(Carbon::parse('2000-02-29'), $today);

        $this->assertEquals('2024-02-29', $next->toDateString());
    }

    public function test_upcoming_buckets_and_age(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 5, 1));
        try {
            $friends = [
                $this->friend('Hari Ini', '2000-05-01'),   // 0 hari, usia 26
                $this->friend('Besok', '1996-05-02'),      // 1 hari, usia 30
                $this->friend('Lusa', '2010-05-04'),       // 3 hari, usia 16
                $this->friend('Jauh', '1990-06-15'),       // > 7 hari, dikecualikan
                new Friend(['name' => 'Tanpa Tanggal']),   // dikecualikan
            ];

            $result = $this->service->upcoming($friends, Carbon::today(), 7);

            $this->assertCount(3, $result);
            $this->assertSame('today', $result[0]['bucket']);
            $this->assertSame(0, $result[0]['days_until']);
            $this->assertSame(26, $result[0]['age_turning']);
            $this->assertSame('tomorrow', $result[1]['bucket']);
            $this->assertSame(1, $result[1]['days_until']);
            $this->assertSame('upcoming', $result[2]['bucket']);
            $this->assertSame(3, $result[2]['days_until']);
        } finally {
            Carbon::setTestNow();
        }
    }

    public function test_upcoming_wraps_around_new_year(): void
    {
        $today = Carbon::create(2024, 12, 30);
        $result = $this->service->upcoming(
            [$this->friend('Tahun Baru', '2000-01-02')],
            $today,
            7
        );

        $this->assertCount(1, $result);
        $this->assertSame(3, $result[0]['days_until']);
        $this->assertEquals('2025-01-02', $result[0]['date']->toDateString());
    }

    public function test_refresh_is_idempotent_and_unread_countable(): void
    {
        $user = User::factory()->create();
        Friend::create(['name' => 'Ayu', 'birth_date' => Carbon::today()->toDateString()]);
        Friend::create(['name' => 'Budi', 'birth_date' => Carbon::today()->addDay()->toDateString()]);

        $this->service->refreshUserNotifications($user, Carbon::today(), 7);
        $this->service->refreshUserNotifications($user, Carbon::today(), 7);

        $this->assertSame(2, $this->service->unreadCount($user));

        $user->birthdayNotifications()->first()->update(['read_at' => now()]);
        $this->assertSame(1, $this->service->unreadCount($user));
    }
}
