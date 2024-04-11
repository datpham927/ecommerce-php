@extends('pages.order.container')


@section("view")

<div class="container" style="width: 100%;">
  @if(count($orders)>0)
    @foreach($orders as $itemOrder)
    <div style="background-color: white; padding:10px 20px; border-radius: 2px; margin: 20px 0;">
        <div>
            <p style="margin: 0;">Giao vào
                {{ \Carbon\Carbon::parse($itemOrder->od_dateShipping)->locale('vi')->isoFormat('dddd, DD/MM/YYYY') }}
            </p>
            <p style="color: #FE6133; font-size: 13px;">
                @if ($itemOrder['is_delivering'] && $itemOrder['is_success']) 
                Giao hàng thành công 
                @elseif ($itemOrder['is_confirm_delivery'] && !$itemOrder['is_delivering'])  
                Đang giao hàng 
                @elseif ($itemOrder['is_confirm'] && !$itemOrder['is_confirm_delivery']) 
                Đợi vận chuyển 
                @elseif (!$itemOrder['is_confirm']) 
                Đang chờ xác nhận 
                @elseif ($itemOrder['is_canceled']) 
                Đã hủy 
                @endif
            </p>
        </div>

        @foreach($itemOrder->OrderDetail as $itemOrderDetail)
        <div style="margin: 20px; display: flex; align-items: center;">
            <div style="width: 100px; border: 1px solid #FE6133; border-radius: 4px; overflow: hidden; flex-shrink: 0;">
                <img style="width: 100%" src='{{$itemOrderDetail->product->product_thumb}}' />
            </div>
            <div style="display: flex; flex-direction: column; margin-left: 20px;">
                <p class="long-text" style="font-size: 16px;">
                    {{$itemOrderDetail->product->product_name}}</p>
                <span style="margin: 0; font-size: 12px; text-transform: uppercase;">Size:
                    {{$itemOrderDetail->od_detail_size}}</p>
                    <span style=" font-size: 12px"> 
                    {{number_format($itemOrderDetail->od_detail_price, 0, ',', '.')}}₫ X <span style="color: #FE6133;">{{$itemOrderDetail->od_detail_quantity}}</span></p>
            </div>
        </div>

        @endforeach
        <div style="display: flex;flex-direction: column;align-items: end;justify-content: end;">
            <p style="font-size: 20px;">Tổng tiền: <span style="color: #FE6133;">
                    <?php
                $totalPrice=0;
                      foreach($itemOrder->OrderDetail as $item) {
                        $totalPrice+=$item->od_detail_quantity*$item->od_detail_price;
                      }
                      echo number_format($totalPrice, 0, ',', '.')."₫";
                ?>
                </span>
            </p>
            @if(!$itemOrder['is_confirm']) <a a href='' data-url="{{route('order.isCanceled',['oid'=>$itemOrder['id']])}}" class="btn btn-primary profile-button btn-is-canceled"
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