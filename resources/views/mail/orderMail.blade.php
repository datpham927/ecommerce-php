<!DOCTYPE html>
<html lang="en">

<head>
    <title>Email thông báo đơn hàng</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div style="width: 100%;">
        <div style="padding:10px 20px;">
            <div>
                <div style="font-size: 14px;">Mã đơn hàng:
                    <span style="color: #FA5030;"> #{{$order->id}} </span>
                </div>
                <div style="font-size: 14px;">
                    Trạng thái đơn hàng:
                    <span style="color: #FA5030; ">
                        @if ($order['od_is_delivering'] &&
                        $order['od_is_success']&&!$order['od_is_canceled'])
                        Giao hàng thành công
                        @elseif ($order['od_is_confirm_delivery'] &&
                        !$order['od_is_delivering']&&!$order['od_is_canceled'])
                        Đang giao hàng
                        @elseif ($order['od_is_confirm'] &&
                        !$order['od_is_confirm_delivery']&&!$order['od_is_canceled'])
                        Đợi vận chuyển
                        @elseif (!$order['od_is_confirm']&&!$order['od_is_canceled'])
                        Đang chờ xác nhận
                        @elseif ($order['od_is_canceled'])
                        Đã hủy
                        @endif
                    </span>
                </div>
                <div style="font-size: 14px;">Ngày đặt hàng:
                    <span style="opacity: 0.7">
                        {{ \Carbon\Carbon::parse($order->created_at)->locale('vi')->isoFormat('dddd, DD/MM/YYYY') }}
                    </span>
                </div>
            </div>

            <div style="display: flex;margin: 20px 0;">
                <div style="margin-left: -15px; width:50%">
                    <h3>Địa chỉ người nhận</h3>
                    <div
                        style="background-color: #F5F5FA;margin: 10px 0; padding: 10px; border-radius: 2px; min-height: 90px;">
                        <div style="font-size: 14px;opacity: 0.7">Tên người nhận:
                            <span"> {{  $order->od_user_name}} </span>
                        </div>
                        <div style="font-size: 14px; opacity: 0.7;">Địa chỉ nhận:
                            <span>
                                {{  $order->od_shipping_address}}
                            </span>
                        </div>
                        <div style="font-size: 14px; opacity: 0.7;">Địa chỉ chi tiết:
                            <span>
                                {{  $order->od_shipping_address_detail}}
                            </span>
                        </div>
                        <div style="font-size: 14px;opacity: 0.7">Số điện thoại:
                            <span">
                                {{  $order->od_user_phone}}
                                </span>
                        </div>
                        <div style="font-size: 14px;opacity: 0.7">Thanh toán bằng
                            <span"> {{  $order->od_paymentMethod}} </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="width: 100%;">
            @foreach($order->OrderItem as $orderDetail)
            <div style="margin: 20px; display: flex; align-items: center;">
                <div
                    style="width: 90px; border: 1px solid #FE6133; border-radius: 4px; overflow: hidden; flex-shrink: 0;">
                    <img style="width: 100%" src='{{$orderDetail->product->product_thumb}}' />
                </div>
                <div style="margin-left: 20px;">
                    <p class="long-text" style="font-size: 16px;max-width: 700px">
                        {{$orderDetail->product->product_name}}</p>
                    <span style="margin: 0; font-size: 12px; text-transform: uppercase;">Size:
                        {{$orderDetail->od_item_size}}</p>
                        <span style=" font-size: 12px">
                            {{number_format($orderDetail->od_item_price, 0, ',', '.')}}₫ X <span
                                style="color: #FE6133;">{{$orderDetail->od_item_quantity}}</span></p>
                </div>
            </div>
            @endforeach

        </div>
        <div style="display: flex;flex-direction: column;align-items: end;justify-content: end;">
            <p style="font-size: 20px;">Thanh toán: <span style="color: #FE6133;">
                    <?php
                        $totalPrice=0;
                      foreach($order->OrderItem as $item) {
                        $totalPrice+=$item->od_item_quantity*$item->od_item_price;
                      }
                      echo number_format($totalPrice-$order->od_shipping_price, 0, ',', '.')."₫";
                ?>
                </span>
            </p>
        </div>
    </div>
    </div>
</body>

</html>