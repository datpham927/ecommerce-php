@extends("client.pages.user.index")

@section("content")

<section id="cart_items">
    <div class="container">
        <h2 style="font-weight: 400; margin-left: 20px; font-size: 20px;">Đơn hàng của bạn</h2>
        <div style="display: flex; margin-top: 20px; margin-bottom: 10px;">
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li class="{{$active=='order'?"active":""}}"><a href="{{route("order.order_list")}}" >Tất cả</a></li>
                    <li class="{{$active=='confirm'?"active":""}}"><a  href="{{route("order.confirm")}}" >Chờ xác nhận</a></li>
                    <li class="{{$active=='confirm-delivery'?"active":""}}"><a  href="{{route("order.confirm_delivery")}}" >Vận chuyển</a></li>
                    <li class="{{$active=='delivering'?"active":""}}"><a  href="{{route("order.delivering")}}" >Đang giao</a></li>
                    <li class="{{$active=='success'?"active":""}}"><a  href="{{route("order.success")}}" >Hoàn thành</a></li>
                    <li class="{{$active=='canceled'?"active":""}}"><a  href="{{route("order.canceled")}}" >Đã hủy</a></li>
                </ul>
                
            </div>
        </div>
        @yield('view')
</section>
<!--/#cart_items-->
@endsection