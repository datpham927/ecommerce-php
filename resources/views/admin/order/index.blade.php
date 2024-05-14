@extends("layout.admin")

@section("content")
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Quản lý đơn hàng
        </div>
        <div class="row w3-res-tb" style="margin-bottom: 20px;">

            <form action="{{ url()->current() }}" method="GET" class="col-sm-12 m-b-xs" style="display: flex;">
                <div class="col-sm-6" style="display: flex; justify-items: center; text-align: center;">
                    <input type="text" name='code' value="{{ $code ?? '' }}" class="input-sm form-control"
                        style="margin-right: 20px;" placeholder="Nhập mã đơn hàng">
                    <input id="datepicker" name="date" value="{{ $date ?? '' }}" type="text" placeholder="Ngày đặt hàng"
                        class="input-sm form-control">
                </div>
                <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
            </form>




        </div>
        <div class="table-responsive">
            <div class="col-sm-12">
                <ul class="nav nav-tabs" style="display: flex;">
                    <li class="{{$active=='order'?"active":""}}" style="flex-shrink: 0;"><a
                            href="{{route("admin.order.index")}}">Tất cả</a>
                    </li>
                    <li class="{{$active=='confirm'?"active":""}}" style="flex-shrink: 0;"><a
                            href="{{route("admin.order.confirm")}}">Xác
                            nhận</a></li>
                    <li class="{{$active=='confirm-delivery'?"active":""}}" style="flex-shrink: 0;"><a
                            href="{{route("admin.order.confirm_delivery")}}" style="flex-shrink: 0;">Vận chuyển</a></li>
                    <li class="{{$active=='delivered'?"active":""}}" style="flex-shrink: 0;"><a
                            href="{{route("admin.order.delivered")}}">Đã
                            giao hàng</a></li>

                    <li class="{{$active=='success'?"active":""}}" style="flex-shrink: 0;"><a
                            href="{{route("admin.order.success")}}">Hoàn
                            thành</a></li>
                    <li class="{{$active=='canceled'?"active":""}}" style="flex-shrink: 0;"><a
                            href="{{route("admin.order.canceled")}}">Đã
                            hủy</a></li>
                </ul>

            </div>
            <table class="table table-striped b-t b-light" style="margin-top: 10px;">
                <thead>
                    <tr>
                        <th>Mã Đơn hàng</th>
                        <th>Trạng thái</th>
                        <th>Tên sản phẩm/số lượng</th>
                        <th>Khách hàng phải trả</th>
                        <th style="text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $orderItem)
                    <tr>
                        <td style="text-align: center;">{{$orderItem->id}}</td>
                        <td style="text-align: center; color: chocolate;">
                            @if ($orderItem['od_is_delivering'] &&
                            $orderItem['od_is_success']&&!$orderItem['od_is_canceled'])
                            Giao hàng thành công
                            @elseif ($orderItem['od_is_confirm_delivery'] &&
                            !$orderItem['od_is_delivering']&&!$orderItem['od_is_canceled'])
                            Đang giao hàng
                            @elseif ($orderItem['od_is_confirm'] &&
                            !$orderItem['od_is_confirm_delivery']&&!$orderItem['od_is_canceled'])
                            Đợi vận chuyển
                            @elseif (!$orderItem['od_is_confirm']&&!$orderItem['od_is_canceled'])
                            Đang chờ xác nhận
                            @elseif ($orderItem['od_is_canceled'])
                            Đã hủy
                            @endif
                        </td>
                        <td>
                            @foreach($orderItem->OrderDetail as $orderDetailItem)
                            <div style="display: flex">
                                <p class="text-ellipsis long-text" style="max-width: 350px !important;;">
                                    {{$orderDetailItem->product->product_name}}
                                </p>
                                <span style="color:blue"> x {{$orderDetailItem->od_detail_quantity}}</span> </p>
                            </div>
                            @endforeach

                        </td>
                        <td style="text-align: center;">
                            <?php
                                $totalPrice = 0;
                                foreach($orderItem->OrderDetail as $orderDetail) {
                                    $totalPrice += $orderDetail->od_detail_quantity * $orderDetail->od_detail_price;
                                }
                                echo  number_format($totalPrice , 0, ',', '.')."₫";
                            ?>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column; text-align: center; font-size: 13px;">
                                <a href='{{route('admin.order.detail', ['oid' => $orderItem->id])}}'
                                    style="cursor: pointer;">Xem chi tiết</a>
                                @if (!in_array($active, ['order', 'canceled', 'success']))
                                <a style="cursor: pointer;" class="btn-confirm-status-order" data-url="{{ route(
                                        $active == 'confirm' ? 'admin.order.status.confirmation' :
                                        ($active == 'confirm-delivery' ? 'admin.order.status.confirm_delivery' :
                                      'admin.order.status.delivered'  ), ['oid' => $orderItem->id]) }}">
                                    Xác nhận
                                </a>
                                </a>
                                @endif


                            </div>
                        </td>
                    </tr>
                    @endforeach


                </tbody>

            </table>
        </div>
        <footer class="panel-footer">
             @include('components.empty',['list'=>$orders,'title'=>'Không có đơn hàng nào!'])
        </footer>
    </div>
</div>

@endsection