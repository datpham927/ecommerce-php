<html>

<head>
    @yield("title")
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
    Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design">
    <script type="application/x-javascript">
    addEventListener("load", function() {
        setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
        window.scrollTo(0, 1);
    }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/i18n/jquery-ui-i18n.min.js"></script>

    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}">
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{asset('backend/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend/css/style-responsive.css')}}" rel="stylesheet">
    <!-- font CSS -->
    <link
        href="//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic"
        rel="stylesheet" type="text/css">
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{asset('backend/css/font.css')}}" type="text/css">
    <link href="{{asset('backend/css/font-awesome.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('backend/css/morris.css')}}" type="text/css">
    <!-- calendar -->
    <link rel="stylesheet" href="{{asset('backend/css/monthly.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/multi-select.css')}}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!-- //font-awesome icons -->
    <script src="{{asset('backend/js/jquery2.0.3.min.js')}}"></script>
    <script src="{{asset('backend/js/raphael-min.js')}}"></script>
    <script src="{{asset('backend/js/morris.js')}}"></script>
    <script src="{{asset('backend/js/index.js')}}"></script>
    <script src="{{asset('backend/js/product.js')}}"></script>
    <script src="{{asset('backend/js/order.js')}}"></script>
    <script src="{{asset('backend/js/role.js')}}"></script>
    <script src="{{asset('backend/js/user_.js')}}"></script>
    <script src="{{asset('backend/js/delivery.js')}}"></script>
    <script src="{{asset('backend/js/multi-select.js')}}"></script>
    <script src="{{asset('frontend/js/notification.js')}}"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @yield("js")
    <link href="node_modules/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="node_modules/froala-editor/js/froala_editor.pkgd.min.js"></script>
    <!-- Bootstrap 5 CSS -->
    <!-- Datepicker CSS (tùy chọn) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <!-- Bootstrap 5 JS và Popper.js (cần thiết cho dropdown của Bootstrap) -->
    <!-- Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            language: 'vi' // Thêm dòng này để thiết lập ngôn ngữ là tiếng Việt
        });
    });
    </script>

</head>

<body>


    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">
                <a href="index.html" class="logo">
                    LOGO
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
                    $notifications = Notification::where(["n_user_id" => null])->orderBy('created_at','desc')->get();
                    $notifications_notseen = Notification::where([
                    'n_user_id' => null,
                    'n_is_watched' => false
                    ])->count();
                    @endphp
                    <li id="header_inbox_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-envelope-o"></i>
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
                                <a href="{{ $notification->n_link }}"class='btn-notification {{!$notification->n_is_watched ?"not-seen":""}}'
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
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <li><a href="#"><i class=" fa fa-suitcase"></i>Hồ sơ</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i> Cài đặt</a></li>
                            <li><a href="{{route('admin.logout')}}"><i class="fa fa-key"></i>Đăng xuất</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->

                </ul>
                <!--search & user info end-->
            </div>
        </header>
        <!--header end-->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation" tabindex="5000" style="overflow: hidden; outline: none;">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a class="active" href="{{URL::to('/dashboard')}}">
                                <i class="fa fa-dashboard"></i>
                                <span>Tổng quan</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="{{route('slider.index')}}">
                                <span>Quản lý slider</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="{{route('category.index')}}">
                                <span>Danh mục sản phẩm</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="{{route('brand.index')}}">
                                <span> Thương hiệu sản phẩm</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="{{route('delivery.index')}}">
                                <span> Phí vận chuyển</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <span>Quản lý sản phẩm</span>
                                <span class="dcjq-icon"></span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{route('product.add')}}"> Thêm sản phẩm</a></li>
                                <li><a href="{{route('product.index')}}"> Danh sách sản phẩm</a></li>
                                <li><a href="{{route('product.draft')}}"> Sản phẩm nháp</a></li>
                                <li><a href="{{route('product.deleted')}}"> Sản phẩm đã xóa</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="{{route('admin.order.index')}}">
                                <span>Quản lý đơn hàng</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <span>Quản lý người dùng</span>
                                <span class="dcjq-icon"></span>
                            </a>
                            <ul class="sub">
                                <li class="sub-menu">
                                    <a href="{{route('staff.index')}}">
                                        <span>Quản lý nhân viên</span>
                                    </a>
                                </li>
                                <li class="sub-menu">
                                    <a href="{{route('customer.index')}}">
                                        <span>Quản lý khách hàng</span>
                                    </a>
                                </li>
                            </ul>

                        </li>

                        <li class="sub-menu">
                            <a href="{{route('role.index')}}">
                                <span>Quản lý vai trò</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="{{route('permission.add')}}">
                                <span>Thêm permission</span>
                            </a>
                        </li>



                    </ul>
                </div>
                <!-- sidebar menu end-->
                <div id="ascrail2000" class="nicescroll-rails"
                    style="width: 3px; z-index: auto; cursor: default; position: absolute; top: 0px; left: 237px; height: 299px; opacity: 0; display: block;">
                    <div
                        style="position: relative; top: 0px; float: right; width: 3px; height: 146px; background-color: rgb(139, 92, 126); border: 0px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 0px;">
                    </div>
                </div>
                <div id="ascrail2000-hr" class="nicescroll-rails"
                    style="height: 3px; z-index: auto; top: 296px; left: 0px; position: absolute; cursor: default; display: none; width: 237px; opacity: 0;">
                    <div
                        style="position: relative; top: 0px; height: 3px; width: 240px; background-color: rgb(139, 92, 126); border: 0px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 0px;">
                    </div>
                </div>
            </div>
        </aside>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                @yield("content")
            </section>
            <!-- footer -->

            <!-- / footer -->
        </section>
        <!--main content end-->
    </section>

    <script src="{{asset('backend/js/bootstrap.js')}}"></script>
    <script src="{{asset('backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
    <script src="{{asset('backend/js/scripts.js')}}"></script>
    <script src="{{asset('backend/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('backend/js/jquery.nicescroll.js')}}"></script>
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{asset('backend/js/flot-chart/excanvas.min.js')}}"></script><![endif]-->
    <script src="{{asset('backend/js/jquery.scrollTo.js')}}"></script>
    <!-- morris JavaScript -->
    <script>
    $(document).ready(function() {
        //BOX BUTTON SHOW AND CLOSE
        jQuery('.small-graph-box').hover(function() {
            jQuery(this).find('.box-button').fadeIn('fast');
        }, function() {
            jQuery(this).find('.box-button').fadeOut('fast');
        });
        jQuery('.small-graph-box .box-close').click(function() {
            jQuery(this).closest('.small-graph-box').fadeOut(200);
            return false;
        });

        //CHARTS
        function gd(year, day, month) {
            return new Date(year, month - 1, day).getTime();
        }

        graphArea2 = Morris.Area({
            element: 'hero-area',
            padding: 10,
            behaveLikeLine: true,
            gridEnabled: false,
            gridLineColor: '#dddddd',
            axes: true,
            resize: true,
            smooth: true,
            pointSize: 0,
            lineWidth: 0,
            fillOpacity: 0.85,
            data: [{
                    period: '2015 Q1',
                    iphone: 2668,
                    ipad: null,
                    itouch: 2649
                },
                {
                    period: '2015 Q2',
                    iphone: 15780,
                    ipad: 13799,
                    itouch: 12051
                },
                {
                    period: '2015 Q3',
                    iphone: 12920,
                    ipad: 10975,
                    itouch: 9910
                },
                {
                    period: '2015 Q4',
                    iphone: 8770,
                    ipad: 6600,
                    itouch: 6695
                },
                {
                    period: '2016 Q1',
                    iphone: 10820,
                    ipad: 10924,
                    itouch: 12300
                },
                {
                    period: '2016 Q2',
                    iphone: 9680,
                    ipad: 9010,
                    itouch: 7891
                },
                {
                    period: '2016 Q3',
                    iphone: 4830,
                    ipad: 3805,
                    itouch: 1598
                },
                {
                    period: '2016 Q4',
                    iphone: 15083,
                    ipad: 8977,
                    itouch: 5185
                },
                {
                    period: '2017 Q1',
                    iphone: 10697,
                    ipad: 4470,
                    itouch: 2038
                },

            ],
            lineColors: ['#eb6f6f', '#926383', '#eb6f6f'],
            xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
            pointSize: 2,
            hideHover: 'auto',
            resize: true
        });


    });
    // display alert
    </script>

    <!-- calendar -->
    <script type="text/javascript" src="{{asset('backend/js/monthly.js')}}"></script>
    <script>
    $(window).load(function() {
        $('#mycalendar').monthly({
            mode: 'event',

        });
        $('#mycalendar2').monthly({
            mode: 'picker',
            target: '#mytarget',
            setWidth: '250px',
            startHidden: true,
            showTrigger: '#mytarget',
            stylePast: true,
            disablePast: true
        });

        switch (window.location.protocol) {
            case 'http:':
            case 'https:':
                // running on a server, should be good.
                break;
            case 'file:':
                alert('Just a heads-up, events will not work when run locally.');
        }
    });
    </script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @yield('js')
    <!-- //calendar -->
    @if(session('success'))
    <script>
    alert("{{ session('success') }}");
    </script>
    @endif
    @if(session('error'))
    <script>
    alert("{{ session('error') }}");
    </script>
    @endif
</body>

</html>