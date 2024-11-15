@extends("client.layout.index")

@section("footer")
@include("client.layout.components.footer")
@endsection

@section("body")

<section id="cart_items">
    <div class="container">
        @include("client.components.breadcrumb")
        <div style="display: flex;">
            <div class="col-sm-7">
                <div class="table-responsive cart_info" style="border: none;">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td class="image" style="font-size: 14px">
                                    <div>Sản phẩm</div>
                                </td>
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
                                <td class="cart_description" style="width: 50%;">
                                    <h4 class="long-text" style="font-size: 14px;font-weight:400">
                                        {{$cartItem->product->product_name}}
                                    </h4>
                                    <p>Size: <span
                                            style="text-transform: uppercase;color: #FC5A32;">{{$cartItem->cart_size}}</span>
                                    </p>
                                </td>
                                <td class="cart_price" style="text-align: center;">
                                    <p style="font-size: 14px;">
                                        {{number_format($cartItem->product->product_price, 0, ',', '.')}}₫
                                    </p>
                                </td>
                                <td class="cart_quantity" style="text-align: center;">
                                    {{$cartItem->cart_quantity}}
                                </td>
                                <td class="cart_total" style="text-align: center;">
                                    <p class="cart_total_price" style="font-size: 16px;">
                                        {{ number_format(($cartItem->product->product_price - ($cartItem->product->product_price * $cartItem->product->product_discount / 100)) * $cartItem->cart_quantity, 0, ',', '.') }}₫
                                    </p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-5">
                <form method="post" action="{{route('order.add_order')}}">
                    @csrf
                    <div style="background-color: white; padding: 20px;border-radius: 3px;">
                        <div style="width: 100%;display: flex; justify-content: space-between; align-items: center;">
                            <h1 style="font-size: 14px; margin: 0;color: rgb(128,128,137);font-weight: 400;">Giao tới
                            </h1>
                            <a style="font-size: 14px;" href='{{route('user.profile')}}'>Cập nhật</a>
                        </div>
                        <input type="text" name="user_name" style="margin: 20px 0;" id="form3Example4"
                            value="{{$user->user_name}}" class="form-control form-control-lg" placeholder="Họ tên*" />
                        <input type="number" name="user_phone" style="margin: 20px 0;" id="form3Example4"
                            value="{{$user->user_mobile ?? ''}}" class="form-control form-control-lg"
                            placeholder="Số điện thoại *" />
                        @if(isset($user->city["name"]))
                        @php
                        $address= $user->city["name"] . ', ' . $user->province["name"] . ', ' . $user->ward["name"]
                        @endphp
                        <button type="button"
                            style="outline: none; text-align: start; background-color:#E9E9ED; cursor: auto;border: none;"
                            class="form-control" fdprocessedid="mgq69">
                            {{ $address}}
                        </button>
                        <input name="user_address" type="hidden" value="{{$address}}" />
                        @endif
                        <input type="text" name="user_address_detail" style="margin: 20px 0;"
                            value="{{old("user_address_detail")}}" id="form3Example4"
                            class="form-control form-control-lg" placeholder="Số nhà, đường *" />
                    </div>
                    <div style="margin: 10px 0; background-color: white; padding: 10px 20px;">
                        <div style="display: flex; justify-content:space-between;">
                            <p>Tổng tiền</p>
                            <span>{{number_format($totalPrice, 0, ',', '.')}}</span>
                        </div>
                        <div style="display: flex; justify-content:space-between;">
                            <p>Phí ship</p>
                            <span>{{number_format($feeship, 0, ',', '.')}}₫</span>
                            <input name="feeship" value="{{$feeship}}" type="hidden" />
                        </div>
                        <div style="display: flex; justify-content:space-between;">
                            <p>Tổng thanh toán</p>
                            <span style="color: #FC5A32;">{{number_format($totalPrice + $feeship, 0, ',', '.')}}₫</span>
                            <input name="od_price_total" value="{{$totalPrice}}" type="hidden" />
                        </div>
                    </div>
                    <div style="margin: 10px 0; background-color: white; padding: 10px 20px;">
                        <h2 style="font-size: 16px;">Chọn hình thức thanh toán</h2>
                        <label style="display: flex;align-items: center; cursor:pointer">
                            <input type="radio" name="od_paymentMethod" value="CASH" />
                            <img style="width: 30px;margin: 0 6px;"
                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAACE4AAAhOAFFljFgAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAmQSURBVHgB7ZxNbBvHFYDfzO7KauhAVJuisJFUdHNsJVNAb61R6tAeirSRT01tCqZOTZGDpNZGUF9MoUCDwmkkH/p3EoXIqXuy+wMESA+WaqCnAKKltrdWVGI7QBDEVCLbCpc7k/dmudSKFv+XFLWeD6C0yx0uyXkz77157w0BNBqNRqPRaDQajUaj0Wg0Go1Go9FoNJoww7wDayQ5hafTADK2e1nmQMKybVizkM3kQBM4SgDWyYkFkDJVvZnM2dwa00IIHtMaPpPyOl/iaJcGW/QuciESKKNz+IhZTnHBBhgDTaAwVD2r+D+Oj6y9tjRa2cAcSaZxmlyiY4MXT+xkr+VAExgc3M5H5OJ+DUxuZrzjIpgx0ASK6R0IKfP1GjMB40Z8IgYdhKG9QUFn0d7U/TxhwGyy/RQXEjqNhXMNhpPofZmTYTf8HHoVBglLFDes+NlzEGKamwFMZqRkm9BBGIgo/n2RPC/1hGAZFALY2auLEEKaEoBkbLF4e2kZOs+03/tCIcxDPLUSRnXUsyqouLaURmszWzqNWsK+iUKIQsjoXRsArhAoFOKe0WLQuQQho6cFQKAndFrFpAgmp8NmlHteALQekJxNls9dexCDkND7AkCK2aVltAdXSqdRiktBSDgUAiDQHmCoHLLqBNcIfSPJUNiDQyMAwuBkD0CFKHBGpM14MgGHnGZDER2hH3W6g6veeu2wzZ5zjE3dxGguHCqUVycW7fW3MnR6qGZAKED1CYwveCq0J2bAXmQOwx05CCGMUbqXxei4pEJXelAALMYMmQ5t7GckOY8hlik6Zg5c6gkVtOMa1mz5CQzAhcXLqaTIzTSUHAlUR/HgBIBxmv74SzF6QLPgYquUDi2PepqioRSCSjQxL9kUDUwAGLufd4S5QQ8rfiYOLYBCSPkCcOEVgo/ABCC9aUUIloAWqYiCKiFYw2dDs/KtJDgjzOEGCNe4uKUsMA8tQkJAYwXlfABjKfT34zY3x1rNFfdPfxAzLCfBpIxJyYfc24pNxmVWSJ57cPnZLBwAgQmA4jXYSfQlSP3E+4aT1wuGOdNqEoWEgKosB4J7oz+OOYFVO55quEAsOr0RtfmRFA4OzLCJBGaUcEaxcj2gxAtSuMeRn9+ley47Dp/dmT/W0P2DIFA3VHKYodWpOmYwbopigmNyXTC4Xe016BXMVxvVdvYtTEeeyaIQ6J5RlRPAxEwjQoj87E7K5mwOP0ljSRwGMfybMkyReur8B+mHrx+bhS5AhVmqzEFIMemUlsd+/GEC7OAxGum1bogdlsIOwy8ODWav6pc9up8BM2LAYr7XjO4nODXqrb45HN4paAcJOZwNY52YDdbIxIZXgxv4OoBGLQbNRqnQa49hroo7qmvF+HdQOAYJyUvM4Gv6RHG6sp3qfMNabrvz1VtAzDDETbId0EE6shCjDrPXrqZQjw/SrBEcTgtMqgiVWPE6kdjt0EaEICSbKb+SyaHKNgXryAJa1pMQFF0QQsdXwqSynOzSDSf7ZoYe4IvzVI5qXEusqmLhfaDnGYNdd1TIFf911NuX0MMZhzoMfIHDnV8eg+3Lx+GFr/dDXUgIpuyYG9xcWYojHlvptlOsS6Ma9fsY2pjr4HpPUYoUqr0KQqxIzvNcyiHBGHVstLyZQcrbts9e0QhlINKNvOdAP4Nov3snEkZjyAQZ9QdvPJuBgGlqBnDsHG+1W171Dk/MQRsodUX+fbn6QREHzqdoHSBxDcB8Bp1K6COGlfDfwzCcdL33OfX8Ebh27ovw9k+fKT938XtPw9svP6P+Dw0atW/AWEdW5O2rICanj4ycnYZ2oFjQ+hIKQUxKf1DOh9q7QF4Ytsv7vB+lnxmrWSnx6x8OYEd/CV74Rv+ejqbjU8/3wcXvPg3/mvky1ARV0dHz7ycgYEgF0ZeJGozHnH0aOFCIenJSnSN3PRtGyQVEAJvDmM1AYW2pLd+5pFYyUQzsbUNRxZNQteQj0JfLV1krGNxJ+HZaPQZ1+iunIur4b//ZgavvPoStR7sFxsPHLUh+8yn43a1tqAeuoEnQyxAgJnZolrI0+JGm0Ie/gW7k7gikSjTHzrjfT+aKa1f3bODwx7bdmM1E1F5/cwbapNTZy+XzGm1xbTsuawhgBDvY48eZjx+7fut/nzXU+aU3I1s0CQHCDSoBL80CXECt0iLBe5i0ANt1665UvpgqFfyBM1U4NXJ2Q3ky3Soj5Hyo1mX/aH/l2xFok2g0vRHo93I36VH4WLDruyvNSuQM+vVVg2t7Cmn3skdlqTthEsIzqhh+rj50GyRy/m7NDQvk6ZB+93R/fkfC+l1bqaP1e7aaAc1QYHLUbjNw518J7+kAI54cx1hOOZaP0zsf4VYm30AE8vFwQX26IQCCOv8X6OmQrt+PpXcfwWvvfAKb9516tyKbNLb9+nPL0AZVBRAEVKvDhNp1+Z16wuiWAPyQO0qG9wdonOm/tyagzv/+7z+qK4SeF0DdNx9O3oSS9xSIAC7c3UA1F4MWIS/pjz8aVAu03956AK/+datme+toYTCfPtHW/rWOBuO6DXPEbWiDv/97B9bQFhB+j6kK+XY7v5IeLEtpDnRBl/Hfi7XakA2gxdg//19QhtfPqa/1qQexeb8Itd8LViBgDr0AMIqasXlfzXDIH14aVJ1M6qYapPtfe+fTWrcBtG03IGAOvQrKz5NKULOgKi9fuw8/+XMebuEM8BtZcknpuV/941P41hsf1jbAmKDpRDDu0M8ABRMzuMBYrXaZOnYTQxAUhvgqqqP/XvyKev7Vv2yp5xpCyo6kKENRnEsVDUyKK82+buuRaKwhhr87MfqJcMwAZPs3z01Hzt87SbH7Wu3ew9lw9MI9aBiVGzbqJnpaJVTl6Vbxs9PUYRAUHUzMe4RKAGSQLacwikmc9r2VLnQ+EboNGiSEh5ePn8ac8WSrs4HsCQmyGwVaod0hQ0aTRjAKYqZBQeSp450iP0H2xHVvO09ojPB+lEYwhdHnIxfuxMHhCcacmAQ+QNcxsLYlpZFj3Mm2G2BrlVALwE+p+PZACnBroTfpHTAHK4AQ/vpJs3RdABJkOeBuliofnjzKFdv57s8Axsp6GNOfc2H64Y1GMN0tV64AJGS7nhEjtWO55e6lUUA/jxzOfcGV+AsS3CfEZPcFAOU9BKHd99UI2PGzhbWl9IEIgKAqiqJTXPCq654UqMSSg3OlsP4nFS45MAH4aWlv8SGkH/rz+SfkB2k1Go1Go9FoNBqNRqPRaDQajUbTU3wOhv0K3EUJHDAAAAAASUVORK5CYII=" />
                            <span style="font-size: 13px;font-weight: 400;">CASH</span>
                        </label>
                        <label style="display: flex;align-items: center; cursor:pointer; margin:10px 0">
                            <input type="radio" name="od_paymentMethod" value="MOMO" />
                            <img style="width: 20px;margin: 0 6px;"
                                src="https://developers.momo.vn/v3/vi/img/logo2.svg" />
                            <span style="font-size: 13px;font-weight: 400;">MOMO</span>
                        </label>
                        <!-- <label style="display: flex;align-items: center; cursor:pointer">
                            <input type="radio" name="od_paymentMethod" value="PAYPAL" />
                            <img style="width:80px;margin: 0 6px;"
                                src="https://dpshopvn.vercel.app/assets/paypal-036f5ec2.svg" />
                        </label>
                        <label style="display: flex;align-items: center; cursor:pointer">
                            <input type="radio" name="od_paymentMethod" value="VNPAY" />
                            <img style="width:80px;margin: 0 6px;"
                                src="https://sandbox.vnpayment.vn/paymentv2/Images/brands/logo.svg" />
                        </label> -->
                    </div>
                    <div style="width: 100%; display: flex; justify-content: end" ;>
                        <button class="btn btn-primary profile-button btn-order"
                            style="padding: 10px 40px; border-radius: 2px;">
                            Đặt hàng
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
<!--/#cart_items-->
@endsection