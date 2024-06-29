@php
use App\Models\setting;
$setting = setting::first();
@endphp

<header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">
        <a href="{{route('admin.dashboard')}}" class="logo">
            <img src="{{$setting->setting_logo??""}}" style="width: 50px;" />
            <span
                style="font-size: 16px; color: white; margin-top: 10px;text-transform: uppercase;">{{$setting->setting_company_name??""}}</span>
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->
    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            @php
            use App\Models\Notification;
            $notifications = Notification::where([
            "n_user_id" => null,
            'n_type' => 'user'])->orderBy('created_at','desc')->get();
            $notifications_notseen = Notification::where([
            'n_user_id' => null,
            'n_is_watched' => false,
            'n_type' => 'user'
            ])->count();
            @endphp
            <li id="header_notification_bar" class="dropdown">
                <a data-toggle="dropdown" href="/" style="padding: 10px 12px;">
                <i class="fa fa-bell-o"></i>
                    <span class="badge bg-important">{{$notifications_notseen??0}}</span>
                </a>
                <ul class="dropdown-menu extended inbox">
                    @if(count($notifications)==0)
                    <div
                        style=" display: flex;height: 400px;  align-items: center;justify-content: center; background-color: white;">
                        <div style="display: flex;flex-direction: column;align-items: center;">
                            <img style='width: 100px;'
                                src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f4.png" />
                            <span style="margin: 10px 0;">Không có thông báo nào</span>
                        </div>
                    </div>
                    @else
                    <li>
                        <p class="red">Bạn có {{ count($notifications) }} thông báo</p>
                    </li>
                    @foreach($notifications as $notification)
                    <li>
                        <a href="{{ $notification->n_link }}"
                            class='btn-notification {{!$notification->n_is_watched ?"not-seen":""}}'
                            data-url="{{route('notification.is-watched',['nid'=>$notification->id])}}">
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
        </ul>
        <!--  notification end -->
    </div>
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" style="padding: 4px;">
                    <img alt="" src="{{Auth::user()->user_image_url??''}}">
                    <span class="username" style="margin-left: 10px;">
                        @if (Auth::check())
                        {{ Auth::user()->user_name }}
                        @endif
                    </span>

                    </span>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="#"><i class=" fa fa-suitcase"></i>Hồ sơ</a></li>
                    <li><a href="{{route('admin.setting')}}"><i class="fa fa-cog"></i> Cài đặt</a></li>
                   
                    <li><a href="{{route('admin.logout')}}"><i class="fa fa-key"></i>Đăng xuất</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->

        </ul>
        <!--search & user info end-->
    </div>
</header>