<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileUserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_returns_user_data_for_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/profile');

        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                ]
            ]);
    }

    public function test_update_profile_with_file_upload()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $avatar = UploadedFile::fake()->image('avatar.jpg');
        $formData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'avatar' => $avatar,
        ];

        $response = $this->postJson('/api/update-profile', $formData);
        $response->assertStatus(200);
    }
}
