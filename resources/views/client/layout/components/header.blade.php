@php
use App\Models\setting;
use App\Models\Notification;

$notifications = collect();
$notifications_notseen = 0;
if (Auth::check()) {
$userId = Auth::id();

$notifications = Notification::where('n_user_id', $userId)
->orWhere('n_type', 'system')
->orderBy('created_at', 'desc')
->get();
$notifications_notseen = Notification::where(function($query) use ($userId) {
$query->where('n_user_id', $userId)
->orWhere('n_type', 'system');
})->where('n_is_watched', false)
->count();
}

$setting = setting::first();
@endphp

<header id="header">
    <!--header-->
    <div class="header_top">
        <!--header_top-->
        <div class="container">
            <div class="row">

                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            @if(!empty($setting->setting_phone))
                            <li style="font-size: 10px; margin-top:10px">
                                <span><i class="fa fa-phone"></i> {{$setting->setting_phone}}</span>
                            </li>
                            @endif

                            @if(!empty($setting->setting_email))
                            <li style="font-size: 10px;margin-top:10px">
                                <span><i class="fa fa-envelope"></i> {{$setting->setting_email}}</span>
                            </li>
                            @endif

                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav" style="display: flex">

                            <li style="display: flex; align-content: center; margin-right:10px ">
                                <div class="btn-notification">
                                    <ion-icon name="notifications"></ion-icon>
                                    <span class="badge bg-important">{{ $notifications_notseen??0}}</span>
                                    <span style="font-size: 13px;margin: 10px;"> Thông báo</span>
                                    <ul class="box-notification">
                                        @if(count($notifications) == 0)
                                        <div
                                            style="display: flex; height: 400px; align-items: center; justify-content: center; background-color: white;">
                                            <div style="display: flex; flex-direction: column; align-items: center;">
                                                <img style='width: 100px;'
                                                    src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f4.png" />
                                                <span style="margin: 10px 0;">Không có thông báo nào</span>
                                            </div>
                                        </div>
                                        @else
                                        <li style="padding: 10px;">
                                            <p style="color:rgb(136, 136, 136);font-size: 14px ;margin: 0;">Bạn có
                                                {{ count($notifications) }} thông báo</p>
                                        </li>
                                        @foreach($notifications as $notification)
                                        <li
                                            class="item-notification {{$notification->n_is_watched==false?"not-seen":""}}">
                                            <a href="{{ $notification->n_link }}" class="btn-notification"
                                                style="display: flex;"
                                                data-url="{{route('notification.is-watched',['nid'=>$notification->id])}}">
                                                <img alt="avatar" style="height: 50px;border-radius: 3px;"
                                                    src="{{ $notification->n_image }}">
                                                <div style="margin-left: 10px;">
                                                    <span class="subject long-text"
                                                        style="max-width: 200px!important; color:black;line-height: 100%; font-size: 14px;">
                                                        {{ $notification->n_title }}
                                                    </span>
                                                    <span class="message text-ellipsis long-text"
                                                        style="max-width: 200px!important; color:rgb(136, 136, 136);line-height: 100%;font-size: 14px">
                                                        {{ $notification->n_subtitle }}
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </li>
                            <li style="display: flex; align-items: center;">
                                @if (Auth::check())
                                <a href="{{ route('user.profile') }}" style="padding: 0;">
                                    <i class="fa fa-user"></i><span>{{ Auth::user()->user_name }}</span>
                                </a>
                                @else
                                <a href="{{ route('user.login') }}" style="padding: 0;">
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
                            <img style="width: 50px;" src="{{ $setting->setting_logo??""}}" alt="" />
                            <span style="font-size: 16px; color: white; margin-top: 10px;text-transform: uppercase;">{{$setting->setting_company_name??""}}</span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-8 col-custom-80">
                    <form action="{{ route('product.search_result') }}" method="GET">
                        <div class="search_box pull-right">
                            <input type="text" name="text" style="font-size: 14px;"
                                placeholder="Nhập từ khóa tìm kiếm...">
                            <button class="btn btn-primary" type="submit">Tìm Kiếm</button>
                        </div>
                    </form>
                </div>
                <div class="col-custom-20 col-sm-2">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            @if(!Auth::check() || (Auth::check() && Auth::user()->user_type === 'customer'))
                            <li>
                                <a href="{{ route('cart.view_Cart') }}" id="cart">
                                    <i class="fa fa-shopping-cart"></i>
                                    @if(Auth::check())
                                    <p class="badge bg-important" style="top: -8px; left: 6px; font-size: 12px;">
                                        {{ count(Auth::user()->carts) }}</p>
                                    @endif
                                    <span style="margin-left: 10px;">Giỏ hàng</span>
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