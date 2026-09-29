<?php

namespace Tests\Feature;

use App\Events\GreetingSent;
use App\Models\Friend;
use App\Models\Greeting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class GreetingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_send_greeting(): void
    {
        $friend = Friend::create(['name' => 'Ayu', 'birth_date' => '2000-01-01']);

        $this->postJson(route('greetings.store', $friend), [
            'message' => 'HBD!',
            'channel' => 'inapp',
        ])->assertUnauthorized();
    }

    public function test_message_is_required_and_channel_must_be_valid(): void
    {
        $user = User::factory()->create();
        $friend = Friend::create(['name' => 'Ayu', 'birth_date' => '2000-01-01']);

        $this->actingAs($user)
            ->post(route('greetings.store', $friend), ['message' => '', 'channel' => 'inapp'])
            ->assertSessionHasErrors('message');

        $this->actingAs($user)
            ->post(route('greetings.store', $friend), ['message' => 'HBD!', 'channel' => 'sms'])
            ->assertSessionHasErrors('channel');
    }

    public function test_user_can_send_inapp_greeting_and_event_dispatched(): void
    {
        Event::fake([GreetingSent::class]);

        $user = User::factory()->create();
        $friend = Friend::create(['name' => 'Budi', 'birth_date' => '1995-05-05']);

        $response = $this->actingAs($user)->postJson(route('greetings.store', $friend), [
            'message' => 'Selamat ulang tahun! 🎂',
            'channel' => 'inapp',
        ]);

        $response->assertCreated()->assertJsonPath('ok', true);

        $this->assertDatabaseHas('greetings', [
            'user_id' => $user->id,
            'friend_id' => $friend->id,
            'message' => 'Selamat ulang tahun! 🎂',
            'channel' => 'inapp',
        ]);

        Event::assertDispatched(GreetingSent::class);
    }

    public function test_whatsapp_greeting_returns_deep_link(): void
    {
        $user = User::factory()->create();
        $friend = Friend::create([
            'name' => 'Citra',
            'phone' => '0812-3456-789',
            'birth_date' => '1998-03-03',
        ]);

        $response = $this->actingAs($user)->postJson(route('greetings.store', $friend), [
            'message' => 'HBD Citra!',
            'channel' => 'whatsapp',
        ]);

        $response->assertCreated();
        $this->assertStringStartsWith(
            'https://wa.me/628123456789?text=',
            $response->json('whatsapp_url')
        );
    }

    public function test_whatsapp_url_helper_handles_missing_phone(): void
    {
        $friend = Friend::create(['name' => 'Danu', 'birth_date' => '2001-07-07']);
        $greeting = new Greeting(['message' => 'HBD!', 'friend' => $friend]);
        $greeting->setRelation('friend', $friend);

        $this->assertNull($greeting->whatsappUrl());
    }

    public function test_user_only_sees_own_greetings_thread(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $friend = Friend::create(['name' => 'Eka', 'birth_date' => '1999-09-09']);

        Greeting::create(['user_id' => $user->id, 'friend_id' => $friend->id, 'message' => 'Punyaku', 'channel' => 'inapp']);
        Greeting::create(['user_id' => $other->id, 'friend_id' => $friend->id, 'message' => 'Punya orang', 'channel' => 'inapp']);

        $response = $this->actingAs($user)->getJson(route('greetings.index', $friend));

        $response->assertOk();
        $this->assertCount(1, $response->json('greetings'));
        $this->assertSame('Punyaku', $response->json('greetings.0.message'));
    }
}
