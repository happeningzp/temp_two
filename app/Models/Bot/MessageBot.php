<?php

namespace App\Models\Bot;
use Illuminate\Database\Eloquent\Model;

class MessageBot extends Model
{
    protected $table = 'history_messages';

    protected $hidden = ['updated_at'];
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(UserBot::class, 'user_id', $this->user_id);
    }
}
