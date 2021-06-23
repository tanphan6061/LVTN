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

        $count = [];
        $count['processing'] = Auth::user()->orders->filter(function ($order) {
            return $order->currentStatus() == 'processing';
        })->count();
        $count['shipping'] = Auth::user()->orders->filter(function ($order) {
            return $order->currentStatus() == 'shipping';
        })->count();
        $count['delivered'] = Auth::user()->orders->filter(function ($order) {
            return $order->currentStatus() == 'delivered';
        })->count();
        $count['cancel'] = Auth::user()->orders->filter(function ($order) {
            return $order->currentStatus() == 'cancel';
        })->count();


        // dd(Auth::user()->orders);
        return view('admin', compact('orders', 'count'));
    }
}
