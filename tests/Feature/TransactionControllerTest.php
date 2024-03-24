<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Coin;
use App\Models\Transaction;


class TransactionControllerTest extends TestCase
{
    // use RefreshDatabase;

    public function test_transactions_table_is_created()
    {
        $this->artisan('migrate');

        $this->assertTrue(Schema::hasTable('transactions'));
    }

    public function test_can_view_transactions()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/transactions');

        $response->assertStatus(200);
    }

    public function test_can_create_transaction()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $coin = Coin::factory()->create();

        $response = $this->post('/api/create-transaction', [
            'coin_name' => $coin->name,
            'quantity' => 5,
            'price_buy' => 100,
            'amount' => 500,
            'date_buy' => now()->format('Y-m-d')
        ]);

        $response->assertStatus(201);
    }

    public function test_can_show_transaction()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $coin = Coin::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'coin_id' => $coin->id,
        ]);

        $response = $this->get("/api/transactions/{$transaction->id}");

        $response->assertStatus(200);
    }

    public function test_can_update_transaction()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $coin = Coin::factory()->create();

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'coin_id' => $coin->id,
            'quantity' => 10,
            'price_buy' => 100,
            'amount' => 500,
            'date_buy' => now()->format('Y-m-d')
        ]);

        $transactionUpdate = [
            'quantity' => 9,
            'price_buy' => 100,
            'amount' => 800,
            'date_buy' => now()->format('Y-m-d')
        ];

        $response = $this->put("/api/update-transaction/{$transaction->id}", $transactionUpdate);

        $response->assertStatus(200);
    }

    public function test_can_delete_transaction()
    {
        $coin = Coin::factory()->create();
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $user->id, 'coin_id' => $coin->id]);

        $this->actingAs($user);

        $response = $this->delete("/api/delete-transaction/{$transaction->id}");

        $response->assertStatus(200);
    }
}
