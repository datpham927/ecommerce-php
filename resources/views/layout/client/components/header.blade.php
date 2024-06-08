<header id="header">
    <!--header-->
    <div class="header_top">
        <!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li style="font-size: 10px;">
                                <a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a>
                            </li>
                            <li style="font-size: 10px;">
                                <a href="#"><i class="fa fa-envelope"></i> info@domain.com</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            @php
                                use App\Models\Notification;
                                $notifications = Notification::where(["n_user_id" => null])->get();
                            @endphp
                            <li id="header_inbox_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <ion-icon name="notifications"></ion-icon>
                                    <span class="badge bg-important">{{ count($notifications) }}</span>
                                </a>
                                <span>Thông báo</span>
                                <ul class="dropdown-menu extended inbox">
                                    @if(count($notifications) == 0)
                                        <div style="display: flex; height: 400px; align-items: center; justify-content: center; background-color: white;">
                                            <div style="display: flex; flex-direction: column; align-items: center;">
                                                <img style='width: 100px;' src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f4.png" />
                                                <span style="margin: 10px 0;">Không có thông báo nào</span>
                                            </div>
                                        </div>
                                    @else
                                        <li>
                                            <p class="red">Bạn có {{ count($notifications) }} thông báo</p>
                                        </li>
                                        @foreach($notifications as $notification)
                                            <li>
                                                <a href="{{ $notification->n_link }}">
                                                    <span class="photo"><img alt="avatar" src="{{ $notification->n_image }}"></span>
                                                    <span class="subject long-text" style="max-width: 200px!important;">
                                                        <span class="from">{{ $notification->n_title }}</span>
                                                    </span>
                                                    <span class="message text-ellipsis long-text" style="max-width: 200px!important;">
                                                        {{ $notification->n_subtitle }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            <li style="display: flex; align-items: center;">
                                @if (Auth::check())
                                    <a href="{{ route('user.profile') }}">
                                        <i class="fa fa-user"></i><span>{{ Auth::user()->user_name }}</span>
                                    </a>
                                @else
                                    <a href="{{ route('user.login') }}">
                                        <span>Đăng nhập</span>
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-middle">
        <!--header-middle-->
        <div class="container">
            <div class="row" style="display: flex; align-items: center;">
                <div class="col-sm-2 logo-min">
                    <div class="logo pull-left">
                        <a href="/" style="display: flex; align-items: center; text-decoration: none;">
                            <img style="width: 50px;" src="{{ asset('frontend/images/home/logo.png') }}" alt="" />
                            <span style="font-size: 16px; color: white; margin-top: 10px;">DATPSHOP</span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-8 col-custom-80">
                    <form action="{{ route('product.search_result') }}" method="GET">
                        <div class="search_box pull-right">
                            <input type="text" name="text" style="font-size: 14px;" placeholder="Nhập từ khóa tìm kiếm...">
                            <button class="btn btn-primary" type="submit">Tìm Kiếm</button>
                        </div>
                    </form>
                </div>
                <div class="col-custom-20 col-sm-2">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            @if(Auth::check() && Auth::user()->user_type == 'customer')
                                <li>
                                    <a href="{{ route('cart.view_Cart') }}">
                                        <i class="fa fa-shopping-cart"></i><span>Giỏ hàng</span>
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('cart.view_Cart') }}">
                                        <i class="fa fa-shopping-cart"></i><span>Giỏ hàng</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/header-middle-->
</header>
<!--/header-->
