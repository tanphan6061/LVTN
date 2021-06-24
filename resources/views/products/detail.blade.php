@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            <li><span>Chi tiết sản phẩm</span></li>
        </ul>
        <div>
            <div>
                <h1>{{ $product->name }}</h1>
                <div>Đánh giá: {{ $product->numberOfReview }}/5.0 <i class="fas fa-star text-warning"></i></div>
            </div>
        </div>
    </div>

    <div class="my-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <img id="avatar-image" class="edit-avatar border"
                    src="{{ count($product->images) ? url($product->images[0]->url) : url('assets/images/placeholder-images.png') }}"
                    alt="avatar user">
                <Button data-toggle="modal" data-target="#album-image-product" class="btn mt-4 btn-primary">Ảnh sản
                    phẩm</Button>
            </div>
            <a href='{{ route('products.edit', $product) }}' class="btn btn-primary">Sửa sản phẩm</a>
        </div>
        <h2 class="mt-4">Thông tin chung:</h2>
        <div class="d-flex">
            <div class="w-25 mt-2  font-weight-bold">Giá sản phẩm:</div>
            <div>{{ number_format($product->price, 0, '', ',') }} vnđ</div>
        </div>
        <div class="d-flex">
            <div class="w-25 mt-2  font-weight-bold">Giảm:</div>
            <div>{{ $product->discount }} %</div>
        </div>
        <div class="d-flex">
            <div class="w-25  mt-2 font-weight-bold">Số lượng:</div>
            <div>{{ $product->amount }}</div>
        </div>
        <div class="d-flex">
            <div class="w-25  mt-2 font-weight-bold">Số sản phẩm được mua tối đa:</div>
            <div>{{ $product->max_buy }}</div>
        </div>
        <div class="d-flex">
            <div class="w-25 mt-2  font-weight-bold">Nhãn hiệu:</div>
            <div>{{ $product->brand->name }}</div>
        </div>
        <div class="d-flex">
            <div class="w-25 mt-2  font-weight-bold">Doanh mục:</div>
            <div>{{ $product->category->name }}</div>
        </div>
        <div class="d-flex">
            <div class="w-25 mt-2  font-weight-bold">Trạng thái:</div>
            <div>{{ $product->status === 'available' ? 'Có sẵn' : 'Ẩn' }}</div>
        </div>


        <h2 class="mt-4">Thông tin chi tiết:</h2>
        <table class="table table-hover border table-striped">
            <thead>
                <tr>
                    <th>Thuộc tính</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product->product_details as $product_detail)
                    <tr>
                        <td>{{ $product_detail->key }}</td>
                        <td>{{ $product_detail->value }}</td>
                    </tr>
                @endforeach
        </table>

        <h2 class="mt-4">Mô tả sản phẩm: </h2>
        <div class="shadow border rounded background-white p-4" style="min-height:200px">
            {{ $product->description }}
        </div>

        <h2 class="mt-4">Đánh giá:</h2>
        <div class="border rounded background-white p-4 shadow" style="height:400px; overflow-y: auto">
            <div class="mb-4">Tổng: {{ $product->reviews->count() }} đánh giá</div>
            @foreach ($product->reviews as $review)
                <div class="d-flex border my-2 p-3 rounded">
                    <div class="d-flex align-items-center border-right" style="width:180px; font-size:1.001rem">
                        <div>{{ $review->user->name }}</div>
                    </div>
                    <div class="ml-3">
                        <div>{{ $review->star }}</div>
                        <div class="my-2">{{ $review->comment }}</div>
                        <div class="text-secondary" style="font-size:0.76rem">Nhận xét vào lúc:
                            {{ date_format($review->updated_at, 'H:i:s, d/m/Y') }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal" id="album-image-product">
        <div class="modal-dialog" style="min-width:85%;">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Ảnh sản phẩm</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="list-image-product mt-3" id="list-image-product">
                        @foreach ($product->images as $image)
                            <img src="{{ url($image->url) }}" />
                        @endforeach
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection
