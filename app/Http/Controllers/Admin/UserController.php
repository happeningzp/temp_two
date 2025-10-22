<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bot\UserBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class UserController extends Controller
{
    /**
     * Управление ползователями БОТОВ
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $pageTitle = '.';
        $users = UserBot::query()->orderByDesc('id')->paginate(20);

        return view('admin.users.list', compact('users', 'pageTitle'));
    }


    public function user($userId)
    {
        $user = UserBot::findOrFail($userId);
        $orders  = $user->orders()->orderByDesc('id')->paginate(10, ['*']);
        return view('admin.users.item', compact( 'user', 'orders'));
    }

    public function update($userId, Request $request)
    {
        $user = UserBot::findOrFail($userId);
        $user->balance = $request->balance;
        $user->is_admin = $request->is_admin;
        $user->save();

        return redirect('/admin/users/'.$userId)->with(['message' => 'Сохранено успешно']);
    }
}
