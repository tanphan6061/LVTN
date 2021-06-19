@extends('layouts.auth')
@section('content')

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div>
                    <section class="login_content">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <h1>Đăng nhập</h1>
                            @error('name')
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
                                    <a href="{{route('suppliers.create')}}" class="to_register"> Tạo tài khoản mới</a>
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
            </div>
        </div>
    </body>
@endsection
