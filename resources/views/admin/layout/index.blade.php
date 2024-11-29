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
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            language: 'vi' // Thêm dòng này để thiết lập ngôn ngữ là tiếng Việt
        });
    });
    </script>
   @vite('resources/css/app.css')
   @vite('resources/js/app.js')
</head>

<body>


    <section id="container">
        <!--header start-->
        @include("admin.layout.components.header")
        <!--header end-->
        <!--sidebar start-->
        <aside>
            @include("admin.layout.components.sidebar")
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
    <script type="text/javascript" src="{{asset('backend/js/monthly.js')}}"></script>
   
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   
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