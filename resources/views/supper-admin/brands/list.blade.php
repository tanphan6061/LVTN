@extends('layouts.app')

@section('content')
    <div class="border-bottom mb-5">
        <ul class="nav--header">
            <li><span>Danh sách thương hiệu</span></li>
        </ul>
        <div class="d-flex justify-content-between align-items-center">
            <h1>Danh sách loại sản phẩm</h1>
            <button class="btn btn-primary">Tạo thương hiệu mới</button>
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
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên thương hiệu</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $key => $brand)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                            <button class="btn btn-primary">Sửa</button>
                            <button class="btn btn-danger">Xoá</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {!! $brands->render('pagination::bootstrap-4') !!}
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

    <script>
        var toggler = document.getElementsByClassName("caret");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
            });
        }

    </script>
@endsection
