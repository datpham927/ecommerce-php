@extends("client.layout.index")

@section("body")
<section id="cart_items">
    @if(count($carts)>0)
    <div class="container">
        @include("client.components.breadcrumb")
        <div class="table-responsive cart_info" style="border: none;">
            <table class='table table-condensed'>
                <thead>
                    <tr class="cart_menu">
                        <td class="image" style="font-size: 14px;text-align: center">Sản phẩm</td>
                        <td class="description" style="font-size: 14px;"></td>
                        <td class="price" style="font-size: 14px;text-align: center">Đơn giá</td>
                        <td class="quantity" style="font-size: 14px; text-align: center;">Số lượng</td>
                        <td class="total" style="font-size: 14px;text-align: center">Thành tiền</td>
                        <td>Xóa</td>
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
                        <td class="cart_quantity">
                            <div class="cart_quantity_button"
                                style="font-size: 14px;display: flex; justify-content: center;">

                                <a class="cart_quantity_down"
                                    data-url="{{route('cart.decrease',["cid"=>$cartItem->id])}}"
                                    style="display: flex;justify-content: center;align-items: center;font-size: 14px;"
                                    href=""> - </a>
                                <input class="cart_quantity_input" type="text" style="font-size: 14px;" name="quantity"
                                    value='{{$cartItem->cart_quantity}}' autocomplete="off" size="2">

                                <a class="cart_quantity_up" data-url="{{route('cart.increase',["cid"=>$cartItem->id])}}"
                                    style="display: flex;justify-content: center;align-items: center;font-size: 14px;"
                                    href=""> + </a>

                            </div>
                        </td>
                        <td class="cart_total" style="text-align: center;">
                            <p class="cart_total_price" style="font-size: 16px;" style=''>
                                {{ number_format(($cartItem->product->product_price - ($cartItem->product->product_price * $cartItem->product->product_discount / 100)) * $cartItem->cart_quantity , 0, ',', '.') }}₫
                            </p>

                        </td>
                        <td>
                            <a class="cart_delete" data-url="{{route('cart.delete',["cid"=>$cartItem->id])}}"
                                style="display: flex;justify-content: center;margin: 0;"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>

                    @endforeach



                </tbody>
            </table>

            <div style="width: 100%; display: flex; justify-content: end; ">
                <a class="btn btn-primary profile-button" href='{{route("order.view_checkout")}}'
                    style="padding: 10px 40px; border-radius: 2px;">
                    Đặt hàng
                </a>
            </div>
        </div>
    </div>
    @else

    <div style=" display: flex;height: 400px;  align-items: center;justify-content: center;">
        <div style="display: flex;flex-direction: column;align-items: center;">
            <img style='width: 100px;'
                src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f4.png" />
            <span style="margin: 10px 0;">Giỏ hàng của bạn còn trống</span>

            <a class="btn btn-primary profile-button" href="{{route('home.index')}}"
                style="padding: 10px 40px; border-radius: 2px;">
                Mua ngay
            </a>
        </div>
    </div>
    @endif
</section>
<!--/#cart_items-->
@endsection