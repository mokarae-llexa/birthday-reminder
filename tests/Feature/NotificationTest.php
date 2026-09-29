<?php

namespace Tests\Feature;

use App\Models\BirthdayNotification;
use App\Models\Friend;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_notifications(): void
    {
        $this->get(route('notifications.index'))->assertRedirect(route('login'));
        $this->getJson(route('api.notifications.feed'))->assertUnauthorized();
    }

    public function test_index_shows_real_birthday_and_persists_notification(): void
    {
        $user = User::factory()->create();
        $friend = Friend::create([
            'name' => 'Pharita',
            'birth_date' => Carbon::today()->toDateString(),
        ]);

        $response = $this->actingAs($user)->get(route('notifications.index'));

        $response->assertOk();
        $response->assertSee('Pharita');
        $this->assertDatabaseHas('birthday_notifications', [
            'user_id' => $user->id,
            'friend_id' => $friend->id,
            'type' => 'today',
        ]);
    }

    public function test_feed_returns_json_with_unread_count(): void
    {
        $user = User::factory()->create();
        Friend::create(['name' => 'Elva', 'birth_date' => Carbon::today()->addDay()->toDateString()]);

        $response = $this->actingAs($user)->getJson(route('api.notifications.feed'));

        $response->assertOk()
            ->assertJsonPath('unread_count', 1)
            ->assertJsonStructure([
                'unread_count',
                'notifications' => [[
                    'id', 'type', 'title', 'message', 'notify_date', 'friend' => ['id', 'name', 'avatar_url'],
                ]],
            ]);
    }

    public function test_user_can_mark_notification_as_read(): void
    {
        $user = User::factory()->create();
        $friend = Friend::create(['name' => 'Neysa', 'birth_date' => Carbon::today()->toDateString()]);
        $notification = BirthdayNotification::create([
            'user_id' => $user->id,
            'friend_id' => $friend->id,
            'type' => 'today',
            'title' => 'Hari ini ulang tahun Neysa!',
            'message' => 'Kirim ucapan.',
            'notify_date' => Carbon::today()->toDateString(),
        ]);

        $this->actingAs($user)
            ->postJson(route('notifications.read', $notification))
            ->assertOk()
            ->assertJsonPath('ok', true);

        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_user_cannot_mark_other_users_notification(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $friend = Friend::create(['name' => 'Diana', 'birth_date' => Carbon::today()->toDateString()]);
        $notification = BirthdayNotification::create([
            'user_id' => $owner->id,
            'friend_id' => $friend->id,
            'type' => 'today',
            'title' => 'x',
            'message' => 'y',
            'notify_date' => Carbon::today()->toDateString(),
        ]);

        $this->actingAs($intruder)
            ->postJson(route('notifications.read', $notification))
            ->assertForbidden();
    }

    public function test_user_can_mark_all_as_read(): void
    {
        $user = User::factory()->create();
        $friend = Friend::create(['name' => 'Sinta', 'birth_date' => Carbon::today()->toDateString()]);
        BirthdayNotification::create([
            'user_id' => $user->id,
            'friend_id' => $friend->id,
            'type' => 'today',
            'title' => 'x',
            'message' => 'y',
            'notify_date' => Carbon::today()->toDateString(),
        ]);

        $this->actingAs($user)
            ->post(route('notifications.read-all'))
            ->assertRedirect();

        $this->assertSame(0, BirthdayNotification::where('user_id', $user->id)->whereNull('read_at')->count());
    }

    public function test_artisan_command_syncs_notifications(): void
    {
        $user = User::factory()->create();
        Friend::create(['name' => 'Komang', 'birth_date' => Carbon::today()->toDateString()]);

        $this->artisan('birthdays:notify')->assertSuccessful();

        $this->assertDatabaseHas('birthday_notifications', [
            'user_id' => $user->id,
            'type' => 'today',
        ]);
    }
}
