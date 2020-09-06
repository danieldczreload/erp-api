<?php

namespace App\Http\Controllers;

use App\work_order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = work_order::with('order_items.order_item_sizes')
                    ->where('status',1)
                    ->get()
                    ->sortBy('order_items.order_item_sizes.order_by');
        return view('home',["orders"=>$orders]);
    }
}
