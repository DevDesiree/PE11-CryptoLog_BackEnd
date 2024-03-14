<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
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
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/transactions');

        $response->assertStatus(200);
    }

    public function test_can_create_transaction()
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/api/create-transaction', [
            'coin_id' => 1,
            'price_buy' => 100,
            'quantity' => 5,
            'amount' => 500,
            'actual_price' => 9000
        ]);

        $response->assertStatus(201);
    }

    public function test_can_update_transaction()
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'coin_id' => 1,
            'quantity' => 10,
            'price_buy' => 100,
            'amount' => 500,
            'actual_price' => 9000
        ]);

        $transactionUpdate = [
            'coin_id' => 1,
            'quantity' => 9,
            'price_buy' => 100,
            'amount' => 800,
            'actual_price' => 9000
        ];

        $response = $this->put("/api/update-transaction/{$transaction->id}", $transactionUpdate);

        $response->assertStatus(200);
    }
}
