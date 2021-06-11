@extends('layouts.app')
@section('content')
    <div class="border-bottom mb-5">
        <ul class="nav--header">
            <li><span>Danh sách thương hiệu</span></li>
        </ul>
        <div class="d-flex justify-content-between align-items-center">
            <h1>Danh sách thương hiệu</h1>
            <button id="btn-modal-add" class="btn btn-primary" data-target="#modal-handle" data-toggle="modal">Tạo thương
                hiệu mới</button>
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
                    <th>Số sản phẩm</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $key => $brand)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>{{$brand->products->count()}}</td>
                        <td>
                            <button data-data='@json($brand)' data-target="#modal-handle" data-toggle="modal"
                                class="btn btn-primary btn-modal-edit">Sửa</button>
                            <button data-toggle="modal" data-id="{{ $brand->id }}" data-name="{{ $brand->name }}"
                                data-target="#modal-delete" class="btn btn-danger btn-modal-delete">Xoá</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {!! $brands->render('pagination::bootstrap-4') !!}
    </div>
@endsection

@section('bodyModalHandle')
    <div class="form-group">
        <label for="name">Tên thương hiệu:</label>
        <input type="name" class="form-control" placeholder="Nhập tên thương hiệu" name="name" id="name">
    </div>
@endsection

@section('bodyScript')
    <script>
        const namePage = 'thương hiệu';
        setModalDeleteInListPage(namePage);
        setModalHandle(namePage);

    </script>
@endsection
