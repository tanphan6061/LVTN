@extends('layouts.app')
@section('content')

    <div class="border-bottom mb-5">
        <ul class="nav--header">
            <li><a href="#">Quản lý các cửa hàng</a></li>
            <li><span>Cửa hàng chưa hoạt động</span></li>
        </ul>
        <div class="d-flex justify-content-between align-items-center">
            <h1>Danh sách các cửa hàng</h1>
        </div>
    </div>
    <div class="border-bottom pb-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">

                <a class="nav-link {{ Route::currentRouteName() == 'suppliers.index' && request()->query('type') !== 'is_activated' ? 'active' : '' }}"
                    href="{{ route('suppliers.index') }}">Cửa hàng chưa hoạt động</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'suppliers.index' && request()->query('type') === 'is_activated' ? 'active' : '' }}"
                    href="{{ route('suppliers.index', ['type' => 'is_activated']) }}">Cửa hàng đang hoạt động</a>
            </li>
        </ul>
    </div>

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
            Tổng: {{ $suppliers->total() }} cửa hàng
        </div>
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Avatar</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Tên cửa hàng</th>
                    <th>Địa chỉ</th>
                    <th>Trạng thái</th>
                    <th>Hoạt động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $key => $supplier)
                    <tr>
                        <th>{{ $key + 1 }}</th>
                        <th>
                            <img style="width:45px;height:45px" class="img-thumbnail" src="{{ url($supplier->avatar) }}"
                                alt="avatar supplier">
                        </th>
                        <th>
                            {{ $supplier->name }}
                        </th>
                        <th>
                            {{ $supplier->email }}
                        </th>
                        <th>
                            {{ $supplier->phone }}
                        </th>
                        <th>
                            {{ $supplier->nameOfShop }}
                        </th>
                        <th>
                            {{ $supplier->address }}
                        </th>
                        <th>
                            {{ $supplier->is_activated ? 'Chưa hoạt động' : 'Đang hoạt đỘng' }}
                        </th>
                        <th>
                            @if ($supplier->is_activated)
                            <button data-toggle="tooltip" data-placement="top" title="Tạm ngưng hoạt động cửa hàng" type="button" class="btn btn-danger">Tạm ngưng</button>
                            @else
                            <button type="button" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="Duyệt cửa hàng hoạt động" >Duyệt</button>
                            @endif
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (count($suppliers) < 1)
            <div class="text-center mt-4 text-secondary">Chưa có cửa hàng nào</div>
        @endif
    </div>
    <div class="d-flex justify-content-center mt-4">
        {!! $suppliers->render('pagination::bootstrap-4') !!}
    </div>

    {{-- <div class="modal" id="modalDelete">
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
    </div> --}}


    {{-- <script>
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

    </script> --}}
@endsection
