 
@extends('client.pages.user.order.container')

@section("view")

<div class="container" style="width: 100%;">
  @if(count($orders)>0)
    @foreach($orders as $orderItem)
    <div style="background-color: white; padding:10px 20px; border-radius: 2px; margin: 20px 0;">
        <div>
            <p style="margin: 0;">Giao vào
                {{ \Carbon\Carbon::parse($orderItem->od_date_shipping)->locale('vi')->isoFormat('dddd, DD/MM/YYYY') }}
            </p>
            <p style="color: #FE6133; font-size: 13px;">
                @if ($orderItem['od_is_delivering'] && $orderItem['od_is_success']&&!$orderItem['od_is_canceled']) 
                Giao hàng thành công 
                @elseif ($orderItem['od_is_confirm_delivery'] && !$orderItem['od_is_delivering']&&!$orderItem['od_is_canceled'])  
                Đang giao hàng 
                @elseif ($orderItem['od_is_confirm'] && !$orderItem['od_is_confirm_delivery']&&!$orderItem['od_is_canceled']) 
                Đợi vận chuyển 
                @elseif (!$orderItem['od_is_confirm']&&!$orderItem['od_is_canceled']) 
                Đang chờ xác nhận 
                @elseif ($orderItem['od_is_canceled']) 
                Đã hủy 
                @endif
            </p>
        </div>

        @foreach($orderItem->OrderItem as $orderItemDetail)
        <div style="margin: 20px; display: flex; align-items: center;">
            <div style="width: 100px; border: 1px solid #FE6133; border-radius: 4px; overflow: hidden; flex-shrink: 0;">
                <img style="width: 100%" src='{{$orderItemDetail->product->product_thumb}}' />
            </div>
            <div style="display: flex; flex-direction: column; margin-left: 20px;">
                <p class="long-text" style="font-size: 16px;">
                    {{$orderItemDetail->product->product_name}}</p>
                <span style="margin: 0; font-size: 12px; text-transform: uppercase;">Size:
                    {{$orderItemDetail->od_item_size}}</p>
                    <span style=" font-size: 12px"> 
                    {{number_format($orderItemDetail->od_item_price, 0, ',', '.')}}₫ X <span style="color: #FE6133;">{{$orderItemDetail->od_item_quantity}}</span></p>
            </div>
        </div> 
        @endforeach
        <div style="display: flex;flex-direction: column;align-items: end;justify-content: end;">
            <p style="font-size: 20px;">Tổng tiền: <span style="color: #FE6133;">
                    <?php
                        $totalPrice=0;
                      foreach($orderItem->OrderItem as $item) {
                        $totalPrice+=$item->od_item_quantity*$item->od_item_price;
                      }
                      echo number_format($totalPrice, 0, ',', '.')."₫";
                ?>
                </span>
            </p>
            @if($active!='order'&&!$orderItem['od_is_confirm']&&$active!='canceled') <a a href='' data-url="{{route('order.isCanceled',['oid'=>$orderItem['id']])}}" class="btn btn-primary profile-button btn-is-canceled"
                style="padding: 10px 40px; border-radius: 2px;">
                 Hủy đơn hàng 
                    </a>
            @endif
        </div>
    </div>
    @endforeach

    @else
    <div style=" display: flex;height: 400px;  align-items: center;justify-content: center;">
        <div style="display: flex;flex-direction: column;align-items: center;">
            <img style='width: 100px;'
                src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f4.png" />
            <span style="margin: 10px 0;">Không có đơn hàng nào!</span>
        </div>
    </div> 
    @endif

</div>

@endsection