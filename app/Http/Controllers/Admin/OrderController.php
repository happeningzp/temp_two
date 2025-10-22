<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bot\OrderBot;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $statuses;

    /**
     * Управление заказами с БОТА
     *
     * @return void
     */
    public function __construct()
    {
        $this->statuses = [
            '0' => 'Запускается 👌',
            '1' => 'Запущен ▶️',
            '2' => 'Выполнен ✅',
            '3' => 'Заблокирован 🚫',
            '4' => 'Отменен/Возврат ↩️'
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        $statuses = $this->statuses;

        $orders  = OrderBot::query()->orderByDesc('id')->paginate(20, ['*']);
        foreach($orders as $order) {
            $api = json_decode($order->comment);
            $order->api = $api->service;
            $order->api_id = $api->order;
        }

        return view('admin.orders.list', compact('orders', 'statuses'));
    }


    /**
     * Вывод заданий на редактирование
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $statuses = $this->statuses;
        $order = OrderBot::findOrFail($id);

        if(!empty($order->comment)) $order->comment = json_decode($order->comment);

        return view('admin.orders.item', compact('order', 'statuses'));
    }


    /**
     * Сохранение заданий
     * @param $orderId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($orderId, Request $request)
    {
        $result = OrderBot::query()->findOrFail($orderId)->update(['status' => $request->status]);

        if (!$result)
            return back()->withInput()->withErrors('Ошибка сохранения');

        return back()
            ->with(['success' => 'Заказ успешно отредактирован']);
    }
}
