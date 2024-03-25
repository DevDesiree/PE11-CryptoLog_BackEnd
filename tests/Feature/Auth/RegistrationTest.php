<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class RegistrationTest extends TestCase
{
    // use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $faker = Faker::create();
        $response = $this->post('/register', [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => 'password2',
            'password_confirmation' => 'password2',
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(201);
    }
}
