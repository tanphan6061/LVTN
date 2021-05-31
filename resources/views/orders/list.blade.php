@extends('layouts.app')
@section('content')

    <div class="border-bottom mb-5">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
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
                <button class="btn btn-primary px-4 ml-1">Tìm</button>
            </div>
        </form>
        <div class="my-3">
            Tổng: {{$orders->total()}} đơn
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
                        <td>{{ $order->price }}</td>
                        <td>{{ $order->discount }}</td>
                        <td>{{ $order->grand_total }}</td>
                        <td>{{ $order->currentStatus() }}</td>
                        <td>
                            <div class="d-inline-block" data-toggle="tooltip" title="Xem chi tiết đơn">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-warning"> <span
                                        class="glyphicon glyphicon-info-sign"></span>
                                </a>
                            </div>
                            <div class="d-inline-block" data-toggle="tooltip" title="Thay đổi trạng thái đơn">
                                <button data-code="{{ $order->code }}" data-id="{{ $order->id }}" data-toggle="modal"
                                    data-target="#modalDelete" class="btn btn-primary delete-discount-code"> <span
                                        class="glyphicon glyphicon-edit"></span>
                                </button>
                            </div>
                            <div class="d-inline-block" data-toggle="tooltip" title="Huỷ đơn">
                                <button data-code="{{ $order->code }}" data-id="{{ $order->id }}" data-toggle="modal"
                                    data-target="#modalDelete" class="btn btn-danger delete-discount-code"> <span
                                        class="glyphicon glyphicon-remove"></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {!! $orders->render('pagination::bootstrap-4') !!}
    </div>

    <div class="modal" id="modalDelete">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 id="header-modal-delete" class="modal-title">Thay đổi trạng thái đơn: 1</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <h2 id="mess-delete">
                        <select class="form-control" id="sel1">
                            <option>Đang giao</option>
                          </select>
                    </h2>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-secondary border">Hủy</button>
                    <button onclick="document.getElementById('delete-form').submit()" id="accept-delete-btn" type="button"
                        class="btn btn-primary">Cập nhật</button>
                    <form method="post" id="delete-form" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>


  <script>
        const btns = document.querySelectorAll('.delete-discount-code');
        btns.forEach(btn => btn.addEventListener('click', (e) => {
            const {
                code,
                id
            } = e.target.dataset;
            console.log(code, id);

            const messDelete = document.getElementById('mess-delete');
            // messDelete.innerHTML = `Bạn muốn huỷ đơn: ${1}?`;

            const deleteForm = document.getElementById('delete-form');
            deleteForm.setAttribute('action', `${location.pathname}/${id}`)
        }))

    </script>
@endsection
