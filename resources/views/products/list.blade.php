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
        <div class="d-flex flex-wrap">
            @foreach ($products as $product)
                <div onclick="changeRoute('{{ route('products.show', $product) }}')"
                    class="border rounded p-1 mt-4 product">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="product-name" href="#">{{ $product->name }}</a>
                        <span>{{ number_format($product->price, 0, '', ',') }} vnđ</span>
                    </div>
                    <div>
                        {{-- {{ dd($product->images[0]->url) }} --}}
                        <img class="product-img" src="{{ $product->images[0]->url ?? '' }}" alt="">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {!! $products->render('pagination::bootstrap-4') !!}
        </div>
        <div>

            <script>
                const changeRoute = (route) => {
                    window.location.href = route;
                }

            </script>
        @endsection
