@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
            <li><span>Thông tin cửa hàng</span></li>
            <li><span>Đổi mật khẩu</span></li>
        </ul>
        <h1>Đổi mật khẩu</h1>
    </div>
    <div class="mt-4">
        <form method="POST" class="needs-validation" novalidate action="{{ route('suppliers.updatePassword') }}">
            @csrf
            <div class="border rounded pt-4 px-5 pb-5">
                @include("suppliers.components.menu")
                <div class="form-group mt-4">
                    <label for="password"><span class="text-danger">*</span> Nhập mật khẩu hiện tại:</label>
                    <input type="password" name="password" value=""
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="Nhập mật khẩu hiện tại" id="password">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <div class="form-group mt-4">
                    <label for="new_password"><span class="text-danger">*</span> Nhập mật khẩu mới:</label>
                    <input type="password" name="new_password" value=""
                        class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}"
                        placeholder="Nhập mật khẩu mới" id="new_password">
                    @if ($errors->has('new_password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('new_password') }}
                        </div>
                    @endif
                </div>
                <div class="form-group mt-4">
                    <label for="new_password"><span class="text-danger">*</span> Nhập mật lại khẩu mới:</label>
                    <input type="password" name="re_new_password" value="" class="form-control"
                        placeholder="Nhập lại mật khẩu mới" id="re_new_password">
                    <div class="invalid-feedback">
                        Mật khẩu mới không khớp
                    </div>

                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('suppliers.show') }}" class="mt-3 px-5 btn btn-secondary">Huỷ</a>
                    <button disabled style="cursor:not-allowed" id="btn-submit" type="submit" class="btn btn-primary mt-3 px-5">Đổi mật khẩu</button>
                </div>
            </div>
    </div>
    </form>
    </div>
    <script>
        const reNewPassword = document.getElementById('re_new_password');
        const newPassword = document.getElementById('new_password');
        const btnSubmit = document.getElementById('btn-submit');
        let check = false;
        reNewPassword.addEventListener('input', (e) => {
            if (e.target.value !== newPassword.value) {
                reNewPassword.setAttribute('class', 'form-control is-invalid')
                btnSubmit.setAttribute('disabled','');
                btnSubmit.setAttribute('style','cursor:not-allowed');
            } else {
                reNewPassword.setAttribute('class', 'form-control')
                btnSubmit.removeAttribute('disabled');
                btnSubmit.removeAttribute('style');
            }
        })

    </script>
@endsection
