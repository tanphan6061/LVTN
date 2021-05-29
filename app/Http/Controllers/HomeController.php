<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders =  Auth::user()->orders->filter(function ($order) {
            return $order->currentStatus() == 'delivered';
        })->map(function ($order) {
            $order->month =  date('m', strtotime($order->created_at));
            $order->year =  date('Y', strtotime($order->created_at));
            return $order;
        });



        return view('admin', compact('orders'));
    }
}
