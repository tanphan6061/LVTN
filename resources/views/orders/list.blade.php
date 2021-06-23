@extends('layouts.app')
@section('content')

    <div class="border-bottom mb-5">
        <ul class="nav--header">
            <li><a href="/">Trang chủ</a></li>
            <li><span>Đơn đặt hàng</span></li>
        </ul>
        <div class="d-flex justify-content-between align-items-center">
            <h1>Danh sách đơn hàng</h1>
            {{-- <a href="{{route('discounts.create')}}" class="btn btn-primary">Danh sách đơn hàng</a> --}}
        </div>
    </div>
    @include("orders.components.menu")
    <div class="table-responsive">
        <form action="">
            <div class="form-group d-flex">
                <input value="{{ request()->get('q') }}" name="q" placeholder="Nhập từ khoá cần tìm" type="text"
                    class="form-control" id="usr" autofocus>
                <input type="hidden" name="type" value="{{ request()->get('type') }}" />
                <button class="btn btn-primary px-4 ml-1">Tìm</button>
            </div>
        </form>
        <div class="my-3">
            {{-- Tổng: {{ $orders->total() }} đơn --}}
        </div>
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Người đặt</th>
                    <th>Phương thức thanh toán</th>
                    <th>Giá gốc</th>
                    <th>Giảm giá</th>
                    <th>Tổng hoá đơn</th>
                    <th>Trạng thái</th>
                    <th>Hoạt động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->payment_type }}</td>
                        <td>{{ number_format($order->price, 0, '', ',') }} vnđ</td>
                        <td>{{ number_format($order->discount, 0, '', ',') }} vnđ</td>
                        <td>{{ number_format($order->grand_total, 0, '', ',') }} vnđ</td>
                        <td>{{ $order->currentStatus }}</td>
                        <td>
                            <div class="d-inline-block" data-toggle="tooltip" title="Xem chi tiết đơn">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-warning"> <span
                                        class="glyphicon glyphicon-info-sign"></span>
                                </a>
                            </div>
                            @if ($order->currentStatus !== 'cancel')
                                <div class="d-inline-block" data-toggle="tooltip" title="Thay đổi trạng thái đơn">
                                    <button data-data='@json($order)' data-target="#modal-handle" data-toggle="modal"
                                        class="btn btn-primary btn-modal-edit">
                                        <i style="  pointer-events: none; user-select: none;" class="fa fa-edit"></i>
                                    </button>
                                </div>
                                @if ($order->currentStatus !== 'delivered')
                                    <div class="d-inline-block" data-toggle="tooltip" title="Huỷ đơn">
                                        <button data-toggle="modal" data-id="{{ $order->id }}"
                                            data-name="{{ $order->id }}" data-target="#modal-delete"
                                            class="btn btn-danger btn-modal-delete">Huỷ đơn</button>
                                    </div>
                                @endif
                        @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {!! $orders->render('pagination::bootstrap-4') !!}
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
        setModalDeleteInListPage(namePage);
        setModalHandle('trạng thái đơn đặt hàng');
    </script>
@endsection
