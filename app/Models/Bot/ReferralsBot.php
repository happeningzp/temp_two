<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;

class ReferralsBot extends Model
{
    protected $table = 'referrals';

    /** Вернет реферера */
    public function referer()
    {
        return $this->belongsTo(UserBot::class, 'referral_id', 'user_id');
    }
}
