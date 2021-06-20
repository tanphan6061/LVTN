<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $type = 'processing'; //
        if ($request->type) {
            $type = $request->type;
        }

        DB::enableQueryLog();
        $orders = Auth::user()->orders()
            ->select(
                'orders.*',
                'history_orders.status',
                // 'users.name'
            )
            ->leftJoin(DB::raw('history_orders'), function ($query) use ($type) {
                $query->on('orders.id', '=', 'history_orders.order_id');
            })
            ->where('history_orders.status', $type)
            ->where('history_orders.created_at', function ($query) {
                return $query->selectRaw('max(h2.created_at)')
                    ->from('history_orders as h2')
                    ->whereRaw('history_orders.order_id = h2.order_id');
            })
            ->leftjoin('users', 'users.id', '=', 'orders.user_id')
            ->where(function ($query) use ($request) {
                return  $query->where('users.name', 'like', '%' . $request->q . '%')
                    ->orWhere('orders.id', $request->q);
            })->paginate(12);
        if ($request->q) {
            $orders->setPath('?q=' . $request->q);
        }
        $orders->setPath('?type=' . $request->type);

        return view('orders.list', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
        return view('orders.detail', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $message = 'Cập nhật trạng thái đơn đặt hàng thành công';
        $error = false;
        if (!$order) {
            $message = 'Đơn đặt hàng không tồn tại';
            $error = true;
        }

        // $data = $request->validated();
        if ($order->currentStatus() === 'cancel') {
            $message = 'Không thể cập nhật trạng thái đơn đặt hàng có trạng thái: ' . $order->currentStatus();
            $error = true;
        }
        if (!$request->status) {
            $message = 'Trạng thái đơn hàng là bắt buộc' . $order->currentStatus();
            $error = true;
        }

        if ($error) {
            session(['error' => $message]);
            return $this->respondedError($message, ["isRedirect" => true]);
        }

        $order->history_orders()->create(['status' => $request->status]);
        session(['success' => $message]);
        return $this->responded($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
        if ($order->currentStatus() === 'delivered')
            return redirect()->back()->with('error', 'Không thể huỷ đơn đang ở trạng thái ' . $order->currentStatus());

        $order->history_orders()->create(['status' => 'cancel']);
        return redirect()->back()->with('success', 'Huỷ đơn thành công');
    }
}
