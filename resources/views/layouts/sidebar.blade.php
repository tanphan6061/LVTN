<div class="col-md-3 left_col sticky-top" style="position:sticky">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0">
            <a href="/" class="site_title d-flex align-items-center">
                <img style="width:40px;" src="{{ asset('logo.png') }}" alt="">
                <div style="margin-left : 20px">Taka Seller</div>
            </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ url(Auth::user()->avatar) }}" alt="..." class="img-circle profile_img" />
            </div>
            <div class="profile_info">
                <span>Xin chào,</span>
                <h2>{{ Auth::user()->name }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />
        <!-- sidebar menu -->

        <div id="sidebar-menu" style="height:100vh" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Quản lý cửa hàng</h3>
                <ul class="nav side-menu">
                    <li>
                        {{-- <a><i class="fa fa-home"></i> Trang Chủ
                            <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="index.html">Dashboard</a></li>
                            <li><a href="index2.html">Dashboard2</a></li>
                            <li><a href="index3.html">Dashboard3</a></li>
                        </ul> --}}
                        <a href="{{ route('admin') }}"><i class="fa fa-home"></i> Trang Chủ</a>
                    </li>
                    <li>
                        <a>
                            <i class="fa fa-edit"></i> Đơn Hàng <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('orders.index') }}">Đơn chưa xác nhận</a></li>
                            <li><a href="{{ route('orders.index') }}">Đơn đang giao</a></li>
                            <li><a href="{{ route('orders.index') }}">Đơn đã giao</a></li>
                            <li><a href="{{ route('orders.index') }}">Đơn đã huỷ</a></li>
                        </ul>
                    </li>
                    <li>
                        <a><i class="fa fa-desktop"></i> Sản phẩm
                            <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{ route('products.index') }}">Danh sách sản phẩm</a>
                            </li>
                            <li><a href="{{ route('products.create') }}">Tạo mới/ Đăng sản phẩm</a></li>
                            {{-- <li><a href="typography.html">Đánh giá sản phẩm</a></li> --}}
                        </ul>
                    </li>
                    <li>
                        <a><i class="fa fa-clone"></i>Mã giảm giá
                            <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('discounts.index') }}">Danh sách mã giảm giá</a></li>
                            <li><a href="{{ route('discounts.create') }}">Tạo mã giảm giá mới</a></li>
                        </ul>
                    </li>
                    <li>
                        <a><i class="fa fa-table"></i> Thông tin cửa hàng
                            <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('suppliers.show') }}">Xem thông tin</a></li>
                            <li><a href="{{ route('suppliers.edit') }}">Cập nhật thông tin</a></li>
                            <li><a href="{{ route('suppliers.changePassword') }}">Đổi mật khẩu</a></li>
                        </ul>
                    </li>

                </ul>
            </div>


            @if (Auth::user()->role === 'admin')
                <div class="menu_section">
                    <h3>Quản lý hệ thống</h3>
                    <ul class="nav side-menu">
                        <li>
                            <a><i class="fa fa-users"></i> Quản lý các cửa hàng
                                <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{ route('suppliers.index') }}">Chưa hoạt hoạt động</a></li>
                                <li><a href="{{ route('suppliers.index', ['type' => 'is_activated']) }}">Đang hoạt
                                        động</a></li>
                            </ul>
                        </li>
                        <li>
                            <a><i class="fa fa-clone"></i> Mã giảm giá hệ thống
                                <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{ route('manage-discounts.index') }}">Danh sách mã giảm giá</a></li>
                                <li><a href="{{route('manage-discounts.create')}}">Tạo mã giảm giá mới</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('manage-categories.index') }}"><i class="fa fa-sitemap"></i> Loại sản
                                phẩm
                                {{-- <span class="fa fa-chevron-down"></span> --}}
                            </a>
                            {{-- <ul class="nav child_menu">
                            <li><a href="#level1_1">Danh sách loại sản phẩm</a></li>
                        </ul> --}}
                        </li>
                        <li>
                            <a href="{{ route('manage-brands.index') }}"><i class="fa fa-sitemap"></i> Danh sách
                                thương
                                hiệu
                                {{-- <span class="fa fa-chevron-down"></span></a> --}}
                                {{-- <ul class="nav child_menu">
                            <li><a href="#level1_1">Danh sách thương hiệu</a></li>

                                <li>
                                <a>Danh sách thương hiệu
                                    <span class="fa fa-chevron-down"></span>
                                </a>
                                <ul class="nav child_menu">
                                    <li class="sub_menu">
                                        <a href="level2.html">Level Two</a>
                                    </li>
                                    <li><a href="#level2_1">Level Two</a></li>
                                    <li><a href="#level2_2">Level Two</a></li>
                                </ul>
                                </li>

                            {{-- <li><a href="#level1_2">Level One</a></li>
                        </ul> --}}
                        </li>
                    </ul>
                </div>
            @endif

        </div>
        <!-- /sidebar menu -->

        {{-- <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div> --}}
        <!-- /menu footer buttons -->
    </div>
</div>
