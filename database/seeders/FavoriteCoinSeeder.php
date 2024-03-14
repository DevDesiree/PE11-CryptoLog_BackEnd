<?php

namespace Database\Seeders;

use App\Models\Favorite_coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteCoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Favorite_coin::factory()->count(10)->create();
    }
}
