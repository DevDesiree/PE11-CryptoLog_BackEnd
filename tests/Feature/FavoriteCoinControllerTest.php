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
    public function test_can_get_favorite_coins()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $favoriteCoinNames = ['Bitcoin', 'Ethereum', 'Litecoin'];

        foreach ($favoriteCoinNames as $coinName) {
            Favorite_coin::factory()->create([
                'user_id' => $user->id,
                'coin_name' => $coinName,
            ]);
        }

        $response = $this->actingAs($user)
            ->get('/api/favorite-coins');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson($favoriteCoinNames); 
    }


    public function test_can_create_favorite_coin()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/favorite-coins', ['coin_name' => 'Bitcoin']);

        $response->assertStatus(Response::HTTP_CREATED);
    }


    public function test_can_delete_favorite_coin()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $favoriteCoin = Favorite_coin::factory()->create([
            'user_id' => $user->id,
            'coin_name' => 'bitcoin'
        ]);

        $response = $this->actingAs($user)
            ->delete("/api/favorite-coins/{$favoriteCoin->coin_name}");

        $response->assertStatus(Response::HTTP_OK);
    }
}
