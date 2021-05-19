@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
            <li><span>Thông tin nhà bán</span></li>
            <li><span>Cập nhật thông tin</span></li>
        </ul>
        <h1>Cập nhật thông tin</h1>
    </div>
    <div class="mt-4">
        <form method="post" class="needs-validation" novalidate action="{{ route('suppliers.update') }}">
            @csrf
            @method('put')
            <div class="border rounded">
                <div class="border-bottom p-4">
                    1. Thông tin chung
                </div>
                <div class="p-4">
                    <div>
                        <img id="avatar-image" class="edit-avatar" src="{{Auth::user()->avatar}}" alt="avatar user">
                        <input  accept="image/png, image/gif, image/jpeg"  id="avatar" type="file" name="avatar" style="display:none" />
                        <button onclick="event.preventDefault();
                        document.getElementById('avatar').click();" class="btn btn-primary">Đổi ảnh đại diện</button>
                    </div>
                    <div class="form-group mt-4">
                        <label for="name"><span class="text-danger">*</span> Tên nhà bán hàng:</label>
                        <input type="name" name="name" value="{{ old('name')?? Auth::user()->name }}"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            placeholder="Nhập tên nhà bán hàng" id="name">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group mt-4">
                        <label for="email"><span class="text-danger">*</span> Địa chỉ email:</label>
                        <input type="email" name="email" value="{{ old('email')?? Auth::user()->email }}"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            placeholder="Nhập địa chỉ email" id="email">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group mt-4">
                        <label for="email"><span class="text-danger">*</span> Tên nhà bán hàng:</label>
                        <input type="email" name="email" value="{{ old('email')?? Auth::user()->email }}"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            placeholder="Nhập địa chỉ email" id="email">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="mt-3 px-5 btn btn-secondary">Huỷ</button>
                        <button class="btn btn-primary mt-3 px-5">Cập nhật</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        const avatarFile = document.getElementById('avatar');
        const avatarImage = document.getElementById('avatar-image');
        avatarFile.addEventListener('change',(e)=>{
            const urlImage = URL.createObjectURL(e.target.files[0]);
            avatarImage.setAttribute('src',urlImage);
        })
    </script>
@endsection
