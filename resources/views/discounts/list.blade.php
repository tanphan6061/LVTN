@extends('layouts.app')
@section('content')

    <div class="border-bottom mb-5">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
            <li><span>Mã giảm giá</span></li>
            <li><span>Danh sách mã giảm giá</span></li>
        </ul>
        <div class="d-flex justify-content-between align-items-center">
            <h1>Danh sách mã giảm giá</h1>
            <a href="{{Request::url()}}/create" class="btn btn-primary">Tạo mã giảm giá mới</a>
        </div>
    </div>
    <div class="table-responsive">
        <form action="" class="mb-2">
            <div class="form-group d-flex">
                <input value="{{ request()->get('q') }}" name="q" placeholder="Nhập từ khoá cần tìm" type="text"
                    class="form-control" id="usr" autofocus>
                <button class="btn btn-primary px-4 ml-1">Tìm</button>
            </div>
        </form>
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã</th>
                    <th>Số lượng</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Giảm (%)</th>
                    <th>Tối thiểu</th>
                    <th>Tối đa</th>
                    <th>Hoạt động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discount_codes as $key => $discount_code)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $discount_code->code }}</td>
                        <td>{{ $discount_code->amount }}</td>
                        <td>{{ $discount_code->start_date }}</td>
                        <td>{{ $discount_code->end_date }}</td>
                        <td>{{ $discount_code->percent }}</td>
                        <td>{{ $discount_code->from_price }}</td>
                        <td>{{ $discount_code->max_price }}</td>
                        <td>
                            <a href="{{route(str_replace('index','edit',Route::currentRouteName()), $discount_code)}}" class="btn btn-warning">Sửa</a>
                            <button data-code="{{ $discount_code->code }}" data-id="{{ $discount_code->id }}"
                                data-toggle="modal" data-target="#modalDelete"
                                class="btn btn-danger delete-discount-code">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {!! $discount_codes->render('pagination::bootstrap-4') !!}
    </div>

    <div class="modal" id="modalDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 id="header-modal-delete" class="modal-title">Xóa mã giảm giá</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <h2 id="mess-delete"></h2>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-secondary border">Hủy</button>
                    <button onclick="document.getElementById('delete-form').submit()" id="accept-delete-btn" type="button"
                        class="btn btn-danger">Xóa</button>
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
            messDelete.innerHTML = `Bạn muốn xóa mã giảm giá: ${code}?`;

            const deleteForm = document.getElementById('delete-form');
            deleteForm.setAttribute('action', `${location.pathname}/${id}`)
        }))

    </script>
@endsection
