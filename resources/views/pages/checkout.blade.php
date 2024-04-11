@extends("layout.client")

@section("footer")
@include("layout.components.footer")
@endsection



@section("body")
<section id="cart_items">
    <div class="container">
        <h2 style="font-weight: 400; margin-left: 20px; font-size: 20px;">Giỏ hàng</h2>
        <div style="display: flex;">
            <div class="col-sm-8">
                <div class="table-responsive cart_info" style="border: none;">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td class="image" style="font-size: 14px">Sản phẩm</td>
                                <td class="description" style="font-size: 14px;"></td>
                                <td class="price" style="font-size: 14px;">Đơn giá</td>
                                <td class="quantity" style="font-size: 14px;">Số lượng</td>
                                <td class="total" style="font-size: 14px;">Thành tiền</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carts as $cartItem)
                            <tr style="background-color: white;">
                                <td style="padding: 20px;text-align: center;">
                                    <img src='{{$cartItem->product->product_thumb}}' style="width: 50px;" alt="">
                                </td>
                                <td class="cart_description " style="width: 50%;">
                                    <h4 class="long-text" style="font-size: 14px;font-weight:400">
                                        {{$cartItem->product->product_name}} </h4>
                                    <p>Size: <span
                                            style="text-transform: uppercase;color: #FC5A32;">{{$cartItem->cart_size}}</span>
                                    </p>
                                </td>

                                <td class="cart_price" style="text-align: center;">
                                    <p style="font-size: 14px; ">
                                        {{number_format($cartItem->Product->product_price , 0, ',', '.')}}₫
                                    </p>
                                </td>
                </div>
                </td>
                <td class="cart_quantity" style="text-align: center;">
                    {{$cartItem->cart_quantity}}
                </td>
                <td class="cart_total" style="text-align: center;">
                    <p class="cart_total_price" style="font-size: 16px;" style=''>
                        {{ number_format(($cartItem->product->product_price - ($cartItem->product->product_price * $cartItem->product->product_discount / 100)) * $cartItem->cart_quantity , 0, ',', '.') }}₫
                    </p>
                </td>
                </tr>
                @endforeach
                </tbody>
                </table>


            </div>
        </div>
        <div class="col-sm-4">
            <div style="background-color: white; padding: 20px;border-radius: 3px;">
                <div style="width: 100%;display: flex; justify-content: space-between; align-items: center;">
                    <h1 style="font-size: 14px; margin: 0;color: rgb(128,128,137);font-weight: 400;">Giao tới</h1>
                    <a style="font-size: 14px;" href='{{route('user.profile')}}'>Cập nhật</a>
                </div>
                <div style="display: flex; margin-top:5px;">
                    <p
                        style="margin: 0;padding-right: 10px;margin-right: 10px; border-right: 2px solid rgb(229,231,235);">
                        {{$user->user_name}}</p>
                    @if($user->user_phone)
                    <span> {{$user->user_phone}}</span>
                    @endif
                </div>
                @if($user->user_address)
                <p style="margin: 0;color: rgb(128,128,137)">{{$user->user_address}}</p>

                @endif
            </div>

            <div style="margin: 10px 0; background-color: white; padding: 10px 20px;">
                <div style="display: flex; justify-content:space-between ;">
                    <p>Tổng tiền</p>
                    <span>
                        {{number_format($totalPrice, 0, ',', '.')}}₫
                    </span>
                </div>
                <div style="display: flex; justify-content:space-between ;">
                    <p>Phí ship</p>
                    <span>
                        {{number_format(25000, 0, ',', '.')}}₫
                    </span>
                </div>
                <div style="display: flex; justify-content:space-between ;">
                    <p>Tổng thanh toán</p>
                    <span style="color: #FC5A32;">
                        {{number_format($totalPrice+25000, 0, ',', '.')}}₫
                    </span>
                </div>
            </div>
            <form style="width: 100%; display: flex; justify-content: end; " method="post"
                action="{{route('order.add_order')}}">
                @csrf
                <button class="btn btn-primary profile-button btn-order" style="padding: 10px 40px; border-radius: 2px;">
                    Đặt hàng
                </button>
        </div>

    </div>
    </div>
    </div>
</section>
<!--/#cart_items-->
@endsection