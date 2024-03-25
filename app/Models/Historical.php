<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historical extends Model
{
    use HasFactory;

    protected $table = 'historicals'; 
    protected $fillable = ['user_id', 'action', 'device', 'ip_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
