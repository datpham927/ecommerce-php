@extends("admin.layout.index")
@section("js")
<script src="{{asset('backend/js/dashboard.js')}}"></script>
@endsection

@section("content")

@include('admin.dashboard.filterDate')
<!-- //market-->
<div class="market-updates">
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-2">
            <div class="col-md-3  market-update-right">
                <i class="fa fa-eye"> </i>
            </div>
            <div class="col-md-9 market-update-left">
                <h4>Truy cập</h4>
                <h3 style="font-size: 1.5em;">{{$visitorCount}}</h3>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-1">
            <div class="col-md-3  market-update-right">
                <i class="fa fa-users"></i>
            </div>
            <div class="col-md-9 market-update-left">
                <h4>Khách hàng</h4>
                <h3 style="font-size: 1.5em;">{{$customerCount}}</h3>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-3">
            <div class="col-md-2  market-update-right">
                <i class="fa fa-usd"></i>
            </div>
            <div class="col-md-10 market-update-left">
                <h4>Doanh thu</h4>
                <h3 style="font-size: 1.5em;">
                    {{ number_format($totalRevenue, 0, ',', '.') }}₫
                </h3>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-4">
            <div class="col-md-3  market-update-right">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </div>
            <div class="col-md-9 market-update-left">
                <h4>Đơn hàng</h4>
                <h3 style="font-size: 1.5em;">{{$orderCount}}</h3>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>
<!-- //market-->
@include('admin.dashboard.chart')

<!-- //tasks -->
<div class="agileits-w3layouts-stats">

    <div class="col-md-6 stats-info stats-last widget-shadow" >
        <div style="text-align: center; background-color: #8b5c7e; padding:10px 0;">
            <h4 style="color:white" >Sản phẩm bán chạy</h4>
        </div>
        <div class="stats-last-agile">
            <table class="table stats-table ">
                <thead>
                    <tr>
                        <th>Top</th>
                        <th>Sản phẩm</th>
                        <th>Đã bán</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topSoldProducts as $index => $item)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td class="text-ellipsis long-text">{{ $item->Product->product_name }}</td>
                        <td>
                            <h5>{{ $item->quantity_sold }}</h5>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6 stats-info stats-last widget-shadow">
    <div style="text-align: center; background-color: #8b5c7e; padding:10px 0;">
            <h4 style="color:white" >Sản phẩm được xem  nhiều nhất</h4>
        </div>
        <div class="stats-last-agile">
            <table class="table stats-table ">
                <thead>
                    <tr>
                        <th>Top</th>
                        <th>Sản phẩm</th>
                        <th>Lượt xem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topViewProducts as $index => $item)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td class="text-ellipsis long-text">{{ $item->product_name }}</td>
                        <td>
                            <h5>{{ $item->product_views }}</h5>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection