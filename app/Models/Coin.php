<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function favorite_coin()
    {
        return $this->belongsTo(User::class);
    }
}
