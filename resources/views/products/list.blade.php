@extends('layouts.app')
@section('content')
    <div class="border-bottom mb-5">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
            <li><span>Sản phẩm</span></li>
            <li><span>Danh sách sản phẩm</span></li>
        </ul>
        <div class="d-flex justify-content-between align-items-center">
            <h1>Danh sách sản phẩm</h1>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Thêm sản phẩm mới</a>
        </div>
    </div>
    <div>
        <form action="">
            <div class="form-group d-flex">
                <input value="{{ request()->get('q') }}" name="q" placeholder="Nhập từ khoá cần tìm" type="text"
                    class="form-control" id="usr" autofocus>
                <button class="btn btn-primary px-4 ml-1">Tìm</button>
            </div>
        </form>
        <div class="container-list">
            @foreach ($products as $product)
                <div onclick="changeRoute(this,'{{ route('products.show', $product) }}')" class="border rounded product shadow">
                {{-- <div class="border rounded product shadow"> --}}

                    <a href="#" class="product-name text-truncate">{{ $product->name }}</a>
                    <div class="my-1">{{ number_format($product->price, 0, '', ',') }} vnđ</div>
                    <div class="product-img">
                        <img class="img-thumbnail"
                            src="{{ $product->images[0]->url ?? url('assets/images/placeholder-images.png') }}" alt="">
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <a href="{{route('products.edit',$product)}}" class="btn-warning btn text-white">Sửa <i class="fa fa-edit"></i></a>
                        <button data-nameProduct="{{ $product->name }}" data-id="{{ $product->id }}" data-toggle="modal"
                            data-target="#modalDelete" class="btn btn-danger delete-product">Xoá <i
                                class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {!! $products->render('pagination::bootstrap-4') !!}
        </div>
        <div class="modal" id="modalDelete">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 id="header-modal-delete" class="modal-title">Xóa sản phẩm</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <h2 id="mess-delete"></h2>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-secondary border">Hủy</button>
                        <button onclick="document.getElementById('delete-form').submit()" id="accept-delete-btn"
                            type="button" class="btn btn-danger">Xóa</button>
                        <form method="post" id="delete-form" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div>

            <script>
                const changeRoute = (e,route) => {
                    window.location.href = route;
                }

                const btns = document.querySelectorAll('.delete-product');
                btns.forEach(btn => btn.addEventListener('click', (e) => {
                    const {
                        nameproduct,
                        id
                    } = e.target.dataset;

                    const messDelete = document.getElementById('mess-delete');
                    messDelete.innerHTML = `Bạn muốn xóa sản phẩm: ${nameproduct}?`;

                    const deleteForm = document.getElementById('delete-form');
                    deleteForm.setAttribute('action', `${location.pathname}/${id}`)
                }))

            </script>
        @endsection
