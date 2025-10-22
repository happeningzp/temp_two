<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bot\PaymentBot;
use App\Models\User;
use App\Models\Bot\UserBot;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     * @param $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = User::find(\Auth::id());

        $pageTitle = 'TikTok';
        $Users = new UserBot();
        $users['all'] = $Users->count;
        $users['today'] = $Users->today;
        $users['yesterday'] = $Users->yesterday;

        $Payments = new PaymentBot();
        $payments['todaySum'] = $Payments->todaySum;
        $payments['today'] = $Payments->today;
        $payments['all'] = $Payments->all;

        return view('admin.index', compact('user', 'pageTitle', 'users', 'payments'));
    }
}
