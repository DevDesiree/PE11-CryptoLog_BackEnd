<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\User;
use App\Models\Favorite_coin;

class FavoriteCoinControllerTest extends TestCase
{
    // use RefreshDatabase;

    public function test_can_create_favorite_coin()
    {
        $user = User::factory()->create();
        $coinId = 1;

        $response = $this->actingAs($user)
                         ->post('/api/favorite-coins', ['coin_id' => $coinId]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_cannot_create_favorite_coin_with_invalid_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->post('/api/favorite-coins', ['coin_id' => 999]); 

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_can_delete_favorite_coin()
    {
        $user = User::factory()->create();
        $favoriteCoin = Favorite_coin::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->delete("/api/favorite-coins/{$favoriteCoin->id}");

        $response->assertStatus(Response::HTTP_OK);
               
    }

    public function test_cannot_delete_non_existing_favorite_coin()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->delete('/api/favorite-coins/999');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
