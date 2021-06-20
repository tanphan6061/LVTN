@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
            <li><a href="{{ route('orders.index') }}">Đơn đặt hàng</a></li>
            <li><span>Chi tiết đơn hàng</span></li>
        </ul>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Mã đơn: {{ $order->id }}</h1>
                <div class="mb-2">Trạng thái hiện tại: {{ $order->currentStatus() }}</div>
            </div>
            <div>
                @if ($order->currentStatus() !== 'cancel')
                    <button data-data='@json($order)' data-target="#modal-handle" data-toggle="modal"
                        class="btn btn-primary btn-modal-edit">
                      Thay đổi trạng thái
                    </button>
                @endif

                @if ($order->currentStatus() !== 'cancel' && $order->currentStatus() !== 'delivered')
                <button data-toggle="modal" data-id="{{ $order->id }}" data-name="{{ $order->id }}"
                    data-target="#modal-delete" class="btn btn-danger btn-modal-delete">Huỷ đơn</button>
                @endif
            </div>
        </div>
    </div>

    <div class="my-4">
        <h2>Lịch sử đơn hàng:</h2>
        <div class="table-responsive" style="max-height:400px">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Trạng thái</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->history_orders as $key => $history_order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $history_order->status }}</td>
                            <td>{{ date_format($history_order->created_at, 'H:i:s, d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr>
        <h2>Chi tiết đơn:</h2>
        <div class="d-flex">
            <div class="w-25 font-weight-bold">Họ tên: </div>
            <div>{{ $order->shipping_address->name }}</div>
        </div>
        <div class="d-flex my-3">
            <div class="w-25 font-weight-bold">Số điện thoại: </div>
            <div>{{ $order->shipping_address->phone }}</div>
        </div>
        <div class="d-flex my-3">
            <div class="w-25 font-weight-bold">Địa chỉ: </div>
            <div>{{ $order->shipping_address->address }}</div>
        </div>
        <div class="d-flex my-3">
            <div class="w-25 font-weight-bold">Phương thức thanh toán: </div>
            <div>{{ $order->payment_type }}</div>
        </div>
        <div class="d-flex my-3">
            <div class="w-25 font-weight-bold">Tạm tính: </div>
            <div>{{ number_format($order->price, 0, '', ',') }} vnđ</div>
        </div>
        <div class="d-flex my-3">
            <div class="w-25 font-weight-bold">Giảm giá: </div>
            <div>{{ number_format($order->discount, 0, '', ',') }} vnđ</div>
        </div>
        <div class="d-flex">
            <div class="w-25 font-weight-bold">Tổng giá đơn: </div>
            <div>{{ number_format($order->grand_total, 0, '', ',') }} vnđ</div>
        </div>
    </div>
    <hr>
    <h2>Chi tiết sản phẩm:</h2>

    <div class="table-xl table-responsive table-striped">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>Sẩm phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiên</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->order_details as $order_detail)
                    <tr class="border-top">
                        <td>
                            <div style="width:50px;height:50px">
                                <img style="width: 100%;
                                                height: 100%;
                                                object-fit: cover;" class="img-thumbnail"
                                    src="{{ $order_detail->product->images[0]->url ?? url('assets/images/placeholder-images.png') }}"
                                    alt="">
                            </div>
                            <div class="mt-1">
                                {{ $order_detail->product->name }}
                            </div>
                        </td>
                        <td>{{ $order_detail->quantity }}</td>
                        <td>{{ number_format($order_detail->price, 0, '', ',') }} vnđ</td>
                        <td>{{ number_format($order_detail->price - $order_detail->discount, 0, '', ',') }} vnđ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('bodyModalHandle')
    <select class="form-control" name="status" class="p-3" id="status">
        <option value="processing">Chưa xác nhận</option>
        <option value="shipping">Đang giao</option>
        <option value="delivered">Đã giao</option>
    </select>
@endsection

@section('bodyScript')
    <script>
        const namePage = 'đơn đặt hàng';
        setModalDeleteInListPage(namePage,`${location.protocol}//${location.host}/admin/orders`);
        setModalHandle('trạng thái đơn đặt hàng',`${location.protocol}//${location.host}/admin/orders`);
    </script>
@endsection
