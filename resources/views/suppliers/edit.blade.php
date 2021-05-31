@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
            <li><span>Thông tin cửa hàng</span></li>
            <li><span>Cập nhật thông tin</span></li>
        </ul>
        <h1>Cập nhật thông tin</h1>
    </div>
    <div class="mt-4">
        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate
            action="{{ route('suppliers.update') }}">
            @csrf
            @method('put')
            <div class="border rounded pt-4 px-5 pb-5">
                @include("suppliers.components.menu")
                <div class="row pt-4">
                    <div class="col-9">
                        <div class="form-group">
                            <label for="name"><span class="text-danger">*</span> Họ và tên:</label>
                            <input type="name" name="name" value="{{ old('name') ?? Auth::user()->name }}"
                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                placeholder="Nhập địa chỉ name" id="name">
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group mt-4">
                            <label for="email"><span class="text-danger">*</span> Địa chỉ email:</label>
                            <input type="email" name="email" value="{{ old('email') ?? Auth::user()->email }}"
                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                placeholder="Nhập địa chỉ email" id="email">
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group mt-4">
                            <label for="phone"><span class="text-danger">*</span> Số điện thoại:</label>
                            <input type="phone" name="phone" value="{{ old('phone') ?? Auth::user()->phone }}"
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
                        <img id="avatar-image" class="edit-avatar" src="{{ url(Auth::user()->avatar) }}"
                            alt="avatar user">
                        <input accept="image/png, image/gif, image/jpeg" id="avatar" type="file" name="avatar"
                            style="display:none" />
                        <div class="d-flex justify-content-center mt-2">
                            <button onclick="event.preventDefault();
                                    document.getElementById('avatar').click();" class="btn btn-primary">Đổi ảnh đại
                                diện</button>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label for="nameOfShop"><span class="text-danger">*</span> Tên cửa hàng:</label>
                    <input type="nameOfShop" name="nameOfShop"
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
                    <label for="address"><span class="text-danger">*</span> Địa chỉ:</label>
                    <input type="address" name="address" value="{{ old('address') ?? Auth::user()->address }}"
                        class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                        placeholder="Nhập địa chỉ address" id="address">
                    @if ($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('suppliers.show') }}" class="mt-3 px-5 btn btn-secondary">Huỷ</a>
                    <button type="submit" class="btn btn-primary mt-3 px-5">Cập nhật</button>
                </div>
            </div>
    </div>
    </form>
    </div>
    <script>
        const avatarFile = document.getElementById('avatar');
        const avatarImage = document.getElementById('avatar-image');
        avatarFile.addEventListener('change', (e) => {
            const urlImage = URL.createObjectURL(e.target.files[0]);
            avatarImage.setAttribute('src', urlImage);
        })

    </script>
@endsection
