<?php

namespace Tests\Feature;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FriendAvatarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_can_upload_avatar_file_under_2mb(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->create('avatar.jpg', 1500, 'image/jpeg');

        $response = $this->actingAs($user)->post(route('friends.store'), [
            'name' => 'Budi Pertiwi',
            'phone' => '08123456789',
            'email' => 'budi@example.com',
            'birth_date' => '1995-05-15',
            'avatar' => $file,
        ]);

        $response->assertRedirect(route('friends.index'));
        $friend = Friend::first();
        $this->assertEquals('budi@example.com', $friend->email);
        $this->assertNotNull($friend->avatar);
        Storage::disk('public')->assertExists($friend->avatar);
    }

    public function test_can_upload_cropped_base64_avatar(): void
    {
        $user = User::factory()->create();

        $base64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

        $response = $this->actingAs($user)->post(route('friends.store'), [
            'name' => 'Siti Nurhaliza',
            'phone' => '08123456780',
            'birth_date' => '1998-10-20',
            'avatar_base64' => $base64,
        ]);

        $response->assertRedirect(route('friends.index'));
        $friend = Friend::first();
        $this->assertNotNull($friend->avatar);
        Storage::disk('public')->assertExists($friend->avatar);
    }

    public function test_fails_when_avatar_file_exceeds_2mb(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->create('large.jpg', 2500, 'image/jpeg');

        $response = $this->actingAs($user)->post(route('friends.store'), [
            'name' => 'Agus',
            'birth_date' => '1990-01-01',
            'avatar' => $file,
        ]);

        $response->assertSessionHasErrors('avatar');
    }

    public function test_deleting_friend_deletes_avatar_file(): void
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('avatar.jpg', 500, 'image/jpeg');

        $this->actingAs($user)->post(route('friends.store'), [
            'name' => 'Doni',
            'birth_date' => '1992-03-03',
            'avatar' => $file,
        ]);

        $friend = Friend::first();
        $avatarPath = $friend->avatar;
        Storage::disk('public')->assertExists($avatarPath);

        $this->actingAs($user)->delete(route('friends.destroy', $friend->id));
        Storage::disk('public')->assertMissing($avatarPath);
    }

    public function test_can_search_friends(): void
    {
        $user = User::factory()->create();

        Friend::create([
            'name' => 'Alice Johnson',
            'email' => 'alice@test.com',
            'phone' => '08111',
            'birth_date' => '1995-01-01',
        ]);

        Friend::create([
            'name' => 'Bob Smith',
            'email' => 'bob@test.com',
            'phone' => '08222',
            'birth_date' => '1996-02-02',
        ]);

        $response = $this->actingAs($user)->get(route('friends.index', ['search' => 'Alice']));
        $response->assertOk();
        $response->assertSee('Alice Johnson');
        $response->assertDontSee('Bob Smith');
    }
}
