<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    // use RefreshDatabase;

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertOk();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertAuthenticated();

        $response = $this->postJson('/logout');

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson(['message' => 'Sesión cerrada exitosamente.']);

        $this->assertCount(0, $user->tokens);
    }
}
