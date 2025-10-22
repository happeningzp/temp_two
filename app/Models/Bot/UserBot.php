<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class UserBot extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users_bot';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Вернет источник перехода при регистрации
     * @return string
     */
    public function getSourceAttribute()
    {
        $ref = DB::table('referrals')
            ->select(['source'])
            ->where('user_id', '=', $this->user_id)->first(['source']);

        return $ref->source ?? '';
    }

    /** Вернет заказы на подписчиков */
    public function orders()
    {
        return $this->hasMany(OrderBot::class, 'user_id', 'user_id');
    }
    /** Вернет заказы на подписчиков */
    public function ordersViews()
    {
        return $this->hasMany(OrderViewTikTok::class, 'user_id', 'user_id');
    }
    /** Вернет заказы на подписчиков */
    public function ordersLikes()
    {
        return $this->hasMany(OrderLikeTikTok::class, 'user_id', 'user_id');
    }

    /** Вернет сообщения боту */
    public function messages()
    {
        return $this->hasMany(MessageBot::class, 'user_id', 'user_id')->orderByDesc('id')->limit(10);
    }

    /** Вернет историю баланса */
    public function historyBalance()
    {
        return $this->hasMany(HistoryBalanceBot::class, 'user_id', 'user_id')->orderByDesc('id')->limit(10);
    }

    /** Вернет реф инфу */
    public function referral()
    {
        return $this->belongsTo(ReferralsBot::class, 'user_id', 'user_id');
    }

    /** Вернет активность пользователя в читабельном виде */
    public function getActiveAttribute()
    {
        return $this->is_active == 1 ? 'Активный' : 'Удален';
    }

    /** Вернет количество регистраций */
    public function getCountAttribute()
    {
        return $this->query()->count(['id']);
    }

    /** Вернет количество регистраций за сегодня */
    public function getTodayAttribute()
    {
        return $this->query()->whereDate('created_at', today())->count(['id']);
    }

    /** Вернет количество регистраций за вчера */
    public function getYesterdayAttribute()
    {
        return $this->query()->whereDate('created_at', today()->subDay())->count(['id']);
    }
}
