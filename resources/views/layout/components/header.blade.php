<header id="header">
    <!--header-->
    <!--/header_top-->
    <div class="header_top">
        <!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li style="font-size: 10px;"><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a>
                            </li>
                            <li style="font-size: 10px;"><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
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
                <div class="col-sm-3 logo-min">
                    <div class="logo pull-left">
                        <a href="/" style="display: flex; align-items: center; text-decoration: none;"><img
                                style="width: 50px;" src="{{asset('frontend/images/home/logo.png')}}" alt="" />
                            <span style="font-size: 16px;color: white; margin-top: 10px;">
                                DATPSHOP
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-custom-80">
                    <form action="{{ route('product.search_result') }}" method="GET">
                        <div class="search_box pull-right">
                            <input type="text" name="text" style='font-size: 14px;' placeholder="Nhập từ khóa tìm kiếm...">
                            <button class="btn btn-primary" type="submit">Tìm Kiếm</button>
                        </div>
                    </form>
                </div>
                <div class="col-custom-20 col-sm-3 ">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="{{route('cart.view_Cart')}}"><i class="fa fa-shopping-cart"></i><span> Giỏ hàng</span></a>
                            </li>
                            <li>
                            <?php
                                use Illuminate\Support\Facades\Session;
                                $username = Session::get('user_name');
                                if ($username) {
                                    echo '<a href="' . route('user.profile') . '"><i class="fa fa-user"></i><span>' . $username . '</span></a>';
                                } else {
                                    echo '<a href="' . route('user.login') . '"></i><span>Tài khoản</span></a>';
                                }
                                ?> 
                                </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/header-middle-->


    <!--/header-bottom-->
</header>
<!--/header-->