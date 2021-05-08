@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
            <li><span>Sản phẩm</span></li>
            <li><span>Tạo mới</span></li>
        </ul>
        <h1>Tạo sản phẩm</h1>
    </div>
    <div class="mt-4">
        <form action="">
            <div class="border rounded">
                <div class="border-bottom p-4">
                    1. Thông tin chung
                </div>
                <div class="p-4">
                    <div class="form-group mt-4">
                        <label for="name"><span class="text-danger">*</span> Tên sản phẩm:</label>
                        <input type="name" class="form-control" placeholder="Nhập tên sản phẩm" id="name">
                    </div>
                    <div class="form-group mt-4">
                        <label for="price"><span class="text-danger">*</span> Giá:</label>
                        <input type="number" value="1000" type="number" min="1000" step="1000" class="form-control"
                            placeholder="Nhập tên sản phẩm" id="price">
                    </div>
                    <div class="form-group mt-4">
                        <label for="name"><span class="text-danger">*</span> Tên sản phẩm:</label>
                        <input type="name" class="form-control" placeholder="Nhập tên sản phẩm" id="name">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
