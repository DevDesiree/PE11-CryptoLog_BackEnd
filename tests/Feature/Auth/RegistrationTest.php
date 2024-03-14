<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;

class RegistrationTest extends TestCase
{
    // use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $faker = Faker::create();

        $response = $this->post('/register', [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertCreated();
    }
}
