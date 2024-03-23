@extends("layout.client")

@section("footer")
@include("layout.components.footer")
@endsection



@section("body")
<section id="cart_items">
    <div class="container">
        <h2 style="font-weight: 400; margin-left: 20px; font-size: 20px;">Đơn hàng của bạn</h2>
        <div style="display: flex; margin-top: 20px; margin-bottom: 10px;">
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="{{route("order.viewAllOrder")}}" data-toggle="tab">Tất cả</a></li>
                    <li class=""><a  href="{{route("order.confirm")}}" data-toggle="tab">Chờ xác nhận</a></li>
                    <li class=""><a  href="{{route("order.confirm-delivery")}}" data-toggle="tab">Vận chuyển</a></li>
                    <li class=""><a  href="{{route("order.delivering")}}" data-toggle="tab">Đang giao</a></li>
                    <li ><a  href="{{route("order.success")}}" data-toggle="tab">Hoàn thành</a></li>
                    <li ><a  href="{{route("order.canceled")}}" data-toggle="tab">Đã hủy</a></li>
                </ul>
                
            </div>
        </div>
        @yield('view')
</section>
<!--/#cart_items-->
@endsection