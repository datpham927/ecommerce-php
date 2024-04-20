@extends("layout.admin")

@section("content")
<div class="panel panel-default">
    <div class="panel-heading">
        Chi tiết đơn hàng
    </div>
    <div style="padding:10px 20px;">
        <div>
            <div style="font-size: 14px;">Mã đơn hàng:
                <span style="color: #FA5030;"> #{{$orderDetail->id}} </span>
            </div>
            <div style="font-size: 14px;">
                Trạng thái đơn hàng:
                <span style="color: #FA5030; ">
                    @if ($orderDetail['od_is_delivering'] &&
                    $orderDetail['od_is_success']&&!$orderDetail['od_is_canceled'])
                    Giao hàng thành công
                    @elseif ($orderDetail['od_is_confirm_delivery'] &&
                    !$orderDetail['od_is_delivering']&&!$orderDetail['od_is_canceled'])
                    Đang giao hàng
                    @elseif ($orderDetail['od_is_confirm'] &&
                    !$orderDetail['od_is_confirm_delivery']&&!$orderDetail['od_is_canceled'])
                    Đợi vận chuyển
                    @elseif (!$orderDetail['od_is_confirm']&&!$orderDetail['od_is_canceled'])
                    Đang chờ xác nhận
                    @elseif ($orderDetail['od_is_canceled'])
                    Đã hủy
                    @endif
                </span>
            </div>
            <div style="font-size: 14px;">Ngày đặt hàng:
                <span style="opacity: 0.7">
                    {{ \Carbon\Carbon::parse($orderDetail->created_at)->locale('vi')->isoFormat('dddd, DD/MM/YYYY') }}
                </span>
            </div>
        </div>

        <div style="display: flex;margin: 20px 0;">
            <div class="col-lg-6" style="margin-left: -15px;">
                <h3>Địa chỉ người nhận</h3>
                <div style="background-color: #F5F5FA;margin: 10px 0; padding: 10px; border-radius: 2px; min-height: 90px;">
                    <div style="font-size: 14px;opacity: 0.7">Tên người nhận:
                        <span"> {{  $orderDetail->user->user_name}} </span>
                    </div>
                    <div style="font-size: 14px; opacity: 0.7;">Địa chỉ nhận:
                        <span>
                            {{  $orderDetail->od_shippingAddress}}
                        </span>
                    </div>
                    <div style="font-size: 14px;opacity: 0.7">Số điện thoại:
                        <span">
                            {{  $orderDetail->user->user_phone}}
                            </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" style="margin-right: -15px;">
                <h3>Hình thức thanh toán</h3>
                <div style="background-color: #F5F5FA;margin: 10px 0; padding: 10px; border-radius: 2px;min-height: 90px;">
                    <div style="font-size: 14px;opacity: 0.7">Thanh toán bằng
                        <span"> {{  $orderDetail->od_paymentMethod}} </span>
                    </div>
                </div>
            </div>
        </div>

        <div style="width: 100%;">
            @foreach($orderDetail->OrderDetail as $orderItemDetail)
            <div style="margin: 20px; display: flex; align-items: center;">
                <div
                    style="width: 90px; border: 1px solid #FE6133; border-radius: 4px; overflow: hidden; flex-shrink: 0;">
                    <img style="width: 100%" src='{{$orderItemDetail->product->product_thumb}}' />
                </div>
                <div style="display: flex; flex-direction: column; margin-left: 20px;">
                    <p class="long-text" style="font-size: 16px;max-width: 700px !important">
                        {{$orderItemDetail->product->product_name}}</p>
                    <span style="margin: 0; font-size: 12px; text-transform: uppercase;">Size:
                        {{$orderItemDetail->od_detail_size}}</p>
                        <span style=" font-size: 12px">
                            {{number_format($orderItemDetail->od_detail_price, 0, ',', '.')}}₫ X <span
                                style="color: #FE6133;">{{$orderItemDetail->od_detail_quantity}}</span></p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

@endsection