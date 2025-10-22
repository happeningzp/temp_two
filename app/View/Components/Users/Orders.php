<?php

namespace App\View\Components\Users;

use Illuminate\View\Component;

class Orders extends Component
{
    public $orders;

    /**
     * Create a new component instance.
     * @param $orders
     * @return void
     */
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.users.components.orders');
    }
}
