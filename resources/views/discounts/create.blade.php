@extends('layouts.app')
@section('content')

    <div class="border-bottom mb-5">
        <ul class="nav--header">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="{{ route('discounts.index') }}">Mã giảm giá</a></li>
            <li><span>Tạo mã giảm giá mới</span></li>
        </ul>
        <div class="d-flex justify-content-between align-items-center">
            <h1>Tạo mã giảm giá mới</h1>`
        </div>
    </div>
    <div>
        <form method="post" action="{{ route(str_replace('create', 'store', Route::currentRouteName())) }}">
            @csrf
            @method('post')
            @if (isset($categories))
                <div class="row mt-4 ">
                    <div class="form-group col-6">
                        <label for="code"><span class="text-danger">*</span> Mã giảm giá:</label>
                        <input name="code" value="{{ old('code') }}" type="text"
                            class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
                            placeholder="Nhập mã giảm giá" id="code">
                        @if ($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-6">
                        <label for="category_id"><span class="text-danger">*</span> Áp dụng cho loại sản phẩm:</label>
                        <select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                            name="category_id" id="category_id">
                            {{-- <option value="">Tất cả</option> --}}
                            @foreach ($categories as $category)
                                <option value={{ $category->id }}
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('category_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('category_id') }}
                            </div>
                        @endif
                    </div>
                </div>
            @else

                <div class="row mt-4 ">
                    <div class="form-group col-12">
                        <label for="code"><span class="text-danger">*</span> Mã giảm giá:</label>
                        <input name="code" value="{{ old('code') }}" type="text"
                            class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
                            placeholder="Nhập mã giảm giá" id="code">
                        @if ($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="row mt-4 ">
                <div class="form-group col-6">
                    <label for="start_date"><span class="text-danger">*</span> Ngày bắt đầu:</label>
                    <input name="start_date" value="{{ old('start_date') }}" type="date"
                        class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}"
                        placeholder="Nhập ngày bắt đầu" id="start_date">
                    @if ($errors->has('start_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start_date') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label for="end_date"><span class="text-danger">*</span> Ngày kết thúc:</label>
                    <input name="end_date" type="date" value="{{ old('end_date') }}" type="number"
                        class="form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}"
                        placeholder="Nhập ngày kết thúc" id="end_date">
                    @if ($errors->has('end_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('end_date') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row mt-4 ">
                <div class="form-group col-6">
                    <label for="amount"><span class="text-danger">*</span> Số lượng:</label>
                    <input name="amount" value="{{ old('amount') ?? 1 }}" type="number" min="1" step="1"
                        class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" placeholder="Nhập số lượng"
                        id="amount">
                    @if ($errors->has('amount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('amount') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label for="percent"><span class="text-danger">*</span> Giảm (%):</label>
                    <input name="percent" type="number" value="{{ old('percent') ?? 1 }}" type="number" min="0"
                        class="form-control {{ $errors->has('percent') ? 'is-invalid' : '' }}"
                        placeholder="Nhập số phần trăm giảm" id="percent">
                    @if ($errors->has('percent'))
                        <div class="invalid-feedback">
                            {{ $errors->first('percent') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row mt-4 ">
                <div class="form-group col-6">
                    <label for="from_price"><span class="text-danger">*</span> Giảm từ (vnđ):</label>
                    <input name="from_price" value="{{ old('from_price') ?? 1000 }}" type="number" min="1000" step="1000"
                        class="form-control {{ $errors->has('from_price') ? 'is-invalid' : '' }}"
                        placeholder="Nhập giảm từ (vnđ)" id="from_price">
                    @if ($errors->has('from_price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('from_price') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label for="max_price"><span class="text-danger">*</span> Số tiền tối đa được giảm (vnđ):</label>
                    <input name="max_price" type="number" min="1000" step="1000" value="{{ old('max_price') ?? 1000 }}"
                        type="number" class="form-control {{ $errors->has('max_price') ? 'is-invalid' : '' }}"
                        placeholder="Nhập số tiền tối đa được giảm (vnđ)" id="max_price">
                    @if ($errors->has('max_price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('max_price') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href={{ route('discounts.index') }} class="btn btn-secondary  mt-3 px-5">Huỷ</a>
                <button class="btn btn-primary mt-3 px-5">Thêm</button>
            </div>
        </form>
    </div>
@endsection
