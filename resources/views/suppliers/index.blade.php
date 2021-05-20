@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
            <li><span>Thông tin cửa hàng</span></li>
        </ul>
        <h1>Thông tin cửa hàng</h1>
    </div>
    <div class="mt-4">
        <div class="border rounded pt-4 px-5 pb-5">
            @include("suppliers.components.menu")
            <div class="row pt-4">
                <div class="col-9">
                    <div class="form-group">
                        <label for="name">Họ và tên:</label>
                        <input disabled type="name" name="name" value="{{ old('name') ?? Auth::user()->name }}"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            placeholder="Nhập địa chỉ name" id="name">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group mt-4">
                        <label for="email">Địa chỉ email:</label>
                        <input disabled type="email" name="email" value="{{ old('email') ?? Auth::user()->email }}"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            placeholder="Nhập địa chỉ email" id="email">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group mt-4">
                        <label for="phone">Số điện thoại:</label>
                        <input disabled type="phone" name="phone" value="{{ old('phone') ?? Auth::user()->phone }}"
                            class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                            placeholder="Nhập địa chỉ phone" id="phone">
                        @if ($errors->has('phone'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-3">
                    <img id="avatar-image" class="edit-avatar" src="{{ url(Auth::user()->avatar) }}" alt="avatar user">
                    <div class="d-flex justify-content-center mt-2">
                        Ảnh đại diện
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label for="nameOfShop">Tên cửa hàng:</label>
                <input disabled type="nameOfShop" name="nameOfShop"
                    value="{{ old('nameOfShop') ?? Auth::user()->nameOfShop }}"
                    class="form-control {{ $errors->has('nameOfShop') ? 'is-invalid' : '' }}"
                    placeholder="Nhập địa chỉ nameOfShop" id="nameOfShop">
                @if ($errors->has('nameOfShop'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nameOfShop') }}
                    </div>
                @endif
            </div>
            <div class="form-group mt-4">
                <label for="address">Địa chỉ:</label>
                <input disabled type="address" name="address" value="{{ old('address') ?? Auth::user()->address }}"
                    class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                    placeholder="Nhập địa chỉ address" id="address">
                @if ($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
