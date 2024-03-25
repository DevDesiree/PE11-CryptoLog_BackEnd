<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite_coin extends Model
{
    use HasFactory;

    protected $table = 'favorite_coins'; 
    protected $fillable = ['user_id', 'coin_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
