<?php

namespace App\Models\Bot;

use App\Models\ParentPayment;

class PaymentBot extends ParentPayment
{
    protected $table = 'payments';
}
