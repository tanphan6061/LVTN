@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
            <li><span>Sản phẩm</span></li>
            <li><span>Chi tiết sản phẩm</span></li>
        </ul>
        <div>
            <div>
                <h1>{{ $product->name }}</h1>

                <div>Đánh giá: {{ $product->numberOfReview }}/5.0 <i class="fas fa-star text-warning"></i></div>
            </div>

        </div>
    </div>
    <div class="mt-4">
        <h2>Thông tin chung:</h2>
        <div class="d-flex">
            <div class="w-25 font-weight-bold">Giá sản phẩm:</div>
            <div>{{ number_format($product->price, 0, '', ',') }} vnđ</div>
        </div>
        <div class="d-flex">
            <div class="w-25 font-weight-bold">Giảm:</div>
            <div>{{ $product->discount }} %</div>
        </div>
        <div class="d-flex">
            <div class="w-25 font-weight-bold">Số lượng:</div>
            <div>{{ $product->amount }}</div>
        </div>
        <div class="d-flex">
            <div class="w-25 font-weight-bold">Nhãn hiệu:</div>
            <div>{{ $product->brand->name }}</div>
        </div>
        <div class="d-flex">
            <div class="w-25 font-weight-bold">Doanh mục:</div>
            <div>{{ $product->category->name }}</div>
        </div>


        <h2>Thông tin chi tiết:</h2>
        <table class="table table-hover border table-striped">
            <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>John</td>
                    <td>Doe</td>
                    <td>john@example.com</td>
                </tr>
                <tr>
                    <td>Mary</td>
                    <td>Moe</td>
                    <td>mary@example.com</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                </tr>
            </tbody>
        </table>

        <h2>Mô tả sản phẩm: </h2>
        <div class="border rounded background-white p-4" style="min-height:200px">
            {{ $product->description }}
        </div>

        <div data-slick='{"slidesToShow": 4, "slidesToScroll": 4}'>
            <div>
                <h3>1</h3>
            </div>
            <div>
                <h3>2</h3>
            </div>
            <div>
                <h3>3</h3>
            </div>
            <div>
                <h3>4</h3>
            </div>
            <div>
                <h3>5</h3>
            </div>
            <div>
                <h3>6</h3>
            </div>
        </div>
    </div>


    <script>
        $('.center').slick({
            centerMode: true,
            centerPadding: '60px',
            slidesToShow: 3,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });

    </script>
@endsection
