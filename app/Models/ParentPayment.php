<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentPayment extends Model
{
    public function getTodaySumAttribute()
    {
        return $this->query()->whereDate('created_at', today())->sum('amount');
    }

    public function getTodayAttribute()
    {
        return $this->query()->whereDate('created_at', today())->orderByDesc('id')->paginate(5);
    }

    public function getAllAttribute()
    {
        return $this->query()->orderByDesc('id')->paginate(5);
    }
}
