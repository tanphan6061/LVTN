@extends('layouts.auth')
@section('content')

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <h1>Đăng nhập</h1>
                            @error('email')
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    Tài khoản hoặc mật khẩu không chính xác!
                                </div>
                            @enderror

                            <div>
                                <input placeholder="Email" id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                            </div>
                            <div>
                                <input placeholder="Mật khẩu" id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        {{-- {{ __('Login') }} --}}
                                        Đăng nhập
                                    </button>
                                    {{-- @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif --}}
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">Bạn chưa có tài khoản?
                                    <a href="#signup" class="to_register"> Tạo tài khoản mới</a>
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1>
                                        <img src="{{ url('assets/logo.png') }}" alt="">
                                        Taka Seller
                                    </h1>
                                    <p>Taka copyright @2021</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>

                <div id="register" class="animate form registration_form">
                    <section class="login_content">
                        <form>
                            <h1>Tạo tài khoản</h1>
                            <div>
                                <input type="text" name="name" class="form-control" placeholder="Họ tên" required="" />
                            </div>
                            <div>
                                <input type="email" name="email" class="form-control" placeholder="Email" required="" />
                            </div>
                            <div>
                                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại"
                                    required="" />
                            </div>
                            <div>
                                <input type="text" name="nameOfShop" class="form-control" placeholder="Tên shop"
                                    required="" />
                            </div>
                            <div>
                                <input type="text" name="address" class="form-control" placeholder="Địa chỉ" required="" />
                            </div>
                            <div>
                                <input type="password" name="password" class="form-control" placeholder="Mật khẩu"
                                    required="" />
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" required="" />
                            </div>
                            <div>
                                <a class="btn btn-primary submit" href="index.html">Đăng ký</a>
                            </div>

                            <div class="clearfix text-danger mt-2">
                                *Lưu ý: Sau khi bạn đăng ký tài khoản, bạn cần đợi admin hệ thống duyệt tài khoản để khách
                                hàng có thể tìm và mua sản phẩm từ bạn
                            </div>

                            <div class="separator">
                                <p class="change_link">Bạn đã có tài khoản?
                                    <a href="#signin" class="to_register">Đăng nhập</a>
                                </p>
                                <div class="clearfix"></div>
                                <br />
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
@endsection
