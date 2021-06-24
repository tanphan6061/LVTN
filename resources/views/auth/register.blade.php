@extends('layouts.auth')

{{-- @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Đăng Ký
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}

@section('content')

    <body class="login">
        <div class="login_wrapper">
            <div id="">
                <section class="login_content">
                    <form method="POST" action="{{ route('suppliers.store') }}">
                        @csrf
                        <h1>Tạo tài khoản</h1>
                        {{-- {{dd($errors->all())}} --}}
                        <div>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Họ tên"
                                id="name" autofocus>
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <input id="email"  value="{{ old('email') }}" type="text" class="form-control @error('email') is-invalid @enderror"
                                name="email" required autocomplete="email" actofocus placeholder="Email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <input id="phone"  value="{{ old('phone') }}" type="text" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" required autocomplete="phone" actofocus placeholder="Số điện thoại">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <input id="nameOfShop" type="text"  value="{{ old('nameOfShop') }}"
                                class="form-control @error('nameOfShop') is-invalid @enderror" name="nameOfShop" required
                                autocomplete="nameOfShop" actofocus placeholder="Tên cửa hàng">
                            @error('nameOfShop')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <input id="address" value="{{ old('address') }}" type="text" class="form-control @error('address') is-invalid @enderror"
                                name="address" required autocomplete="address" actofocus placeholder="Địa chỉ">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="password" actofocus placeholder="Mật khẩu">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <input id="password_confirmation" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" required autocomplete="password_confirmation" actofocus
                                placeholder="Nhập lại mật khẩu">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                Đăng Ký
                            </button>
                        </div>

                        <div class="clearfix text-danger mt-2">
                            *Lưu ý: Sau khi bạn đăng ký tài khoản, bạn cần đợi admin hệ thống duyệt tài khoản để khách
                            hàng có thể tìm và mua sản phẩm từ bạn
                        </div>

                        <div class="separator">
                            <p class="change_link">Bạn đã có tài khoản?
                                <a href="{{ route('login') }}" class="to_register">Đăng nhập</a>
                            </p>
                            <div class="clearfix"></div>
                            <br />
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </body>
@endsection
