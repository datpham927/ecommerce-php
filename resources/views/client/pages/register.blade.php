<html>

<head>
    <title>Đăng ký</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{asset('frontend/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('frontend/css/style-responsive.css')}}" rel="stylesheet">
    <!-- font CSS -->
    <link
        href="//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic"
        rel="stylesheet" type="text/css">
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{asset('frontend/css/font.css')}}" type="text/css">
    <link href="{{asset('frontend/css/font-awesome.css')}}" rel="stylesheet">
    <!-- //font-awesome icons -->
    <script src="{{asset('js/jquery2.0.3.min.js')}}"></script>
</head>

<body>
    <div style="width: 100%; overflow: hidden; padding: 20px;">

        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="row " style="display: flex; justify-content: center; align-items: center;">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img style="width: 100%;"
                            src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                            class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form action="{{route('user.store_register')}}" method="post">
                            @csrf
                            <!-- Email input -->
                            <div>
                                <h1 style="font-size: 25px;">Tạo tại khoản</h1>
                                <p style="font-size:16px; margin: 10px 0;">Vui lòng nhập địa chỉ gmail</p>
                            </div>
                            <input type="email" required name="user_email" style="margin-top: 20px;" id="form3Example3"
                                class="form-control form-control-lg @error('user_email') is-invalid @enderror"
                                placeholder="Nhập địa chỉ email" />
                            @error('user_email')
                            <div class="alert-danger"  style="background:none;border:none; padding:5px 0;margin: none;">{{ $message }}</div>
                            @enderror
                            <!-- Password input -->
                            <input type="password" required name="user_password" style="margin: 20px 0;" id="form3Example4"
                                class="form-control form-control-lg" placeholder="Nhập mật khẩu" />

                            <input type="password" required name="user_confirm_password" id="form3Example4"
                                class="form-control form-control-lg" placeholder="Xác nhận mật khẩu" />
                            <?php
                                    use Illuminate\Support\Facades\Session;
                                    $message = Session::get("message");
                                    if ($message) {
                                        echo '<div class="alert alert-danger" style="background:none;border:none; padding:5px 0">'. $message . ' </div>';
                                        Session::put("message", null);
                                    }
                                ?>

                            <div class="text-center text-lg-start pt-2" style="margin: 20px 0;">
                                <button type="submit" class="btn btn-primary btn-lg"
                                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng ký</button>
                                <p class="small fw-bold pt-1 mb-0" style="margin-top: 5px;">Đã có tài khoản?<a
                                        href="{{route('user.login')}}" class="link-danger"> Đăng nhập</a></p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>