<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBot extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $guarded = ['id'];

    /** Вернет владельца */
    public function owner()
    {
        return $this->belongsTo(UserBot::class, 'user_id', 'user_id');
    }
}
