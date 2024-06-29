@extends("admin.layout.index")

@section("js")
<script src="{{asset('backend/js/dashboard.js')}}"></script>

@endsection

@section("content")


<div style="padding: 30px 0;">
    <div class="col-sm-12 m-b-xs" style="display: flex;">
        <form autocomplete="off" id="filter-form"
            style="display: flex; justify-items: center; text-align: center; gap:20px">
            <input style="text-align: center;" name="from_date" value="{{ $fromDate ?? '' }}" type="text"
                placeholder="Từ ngày" class="datepicker input-sm form-control input-from-date">
            <input style="text-align: center;" name="to_date" value="{{ $toDate ?? '' }}" type="text"
                placeholder="Đến ngày" class="datepicker input-sm form-control input-to-date">

            <select style="text-align: center;" name="date" class="dashboard-filter form-control">
                <option value="">-- Lọc theo --</option>
                <option value="7ngay" {{ $dateFilter === '7ngay' ? 'selected' : '' }}>7 ngày qua</option>
                <option value="thangtruoc" {{ $dateFilter === 'thangtruoc' ? 'selected' : '' }}>Tháng trước</option>
                <option value="thangnay" {{ $dateFilter === 'thangnay' ? 'selected' : '' }}>Tháng này</option>
                <option value="365ngayqua" {{ $dateFilter === '365ngayqua' ? 'selected' : '' }}>365 ngày qua</option>
            </select>

            <button type="submit">Lọc</button>
            </f>
    </div>
</div>
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
<div class="row">
    <div class="panel-body">
        <div class="col-md-12 w3ls-graph">
            <!--agileinfo-grap-->
            <div class="agileinfo-grap">
                <div class="agileits-box">
                    <header class="agileits-box-header clearfix">
                        <h3>Bản thống kê</h3>
                        <div class="toolbar">
                        </div>
                    </header>
                    <div class="agileits-box-body clearfix">
                        <div id="hero-area"></div>
                    </div>
                </div>
            </div>
            <!--//agileinfo-grap-->

        </div>
    </div>
</div>


<!-- //tasks -->
<div class="agileits-w3layouts-stats">
    <div class="col-md-3  stats-info widget">
        <div class="stats-info-agileits">
            <div class="stats-title">
                <h4 class="title">Browser Stats</h4>
            </div>
            <div class="stats-body">
                <ul class="list-unstyled">
                    <li>GoogleChrome <span class="pull-right">85%</span>
                        <div class="progress progress-striped active progress-right">
                            <div class="bar green" style="width:85%;"></div>
                        </div>
                    </li>
                    <li>Firefox <span class="pull-right">35%</span>
                        <div class="progress progress-striped active progress-right">
                            <div class="bar yellow" style="width:35%;"></div>
                        </div>
                    </li>
                    <li>Internet Explorer <span class="pull-right">78%</span>
                        <div class="progress progress-striped active progress-right">
                            <div class="bar red" style="width:78%;"></div>
                        </div>
                    </li>
                    <li>Safari <span class="pull-right">50%</span>
                        <div class="progress progress-striped active progress-right">
                            <div class="bar blue" style="width:50%;"></div>
                        </div>
                    </li>
                    <li>Opera <span class="pull-right">80%</span>
                        <div class="progress progress-striped active progress-right">
                            <div class="bar light-blue" style="width:80%;"></div>
                        </div>
                    </li>
                    <li class="last">Others <span class="pull-right">60%</span>
                        <div class="progress progress-striped active progress-right">
                            <div class="bar orange" style="width:60%;"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8 stats-info stats-last widget-shadow">
        <div class="stats-last-agile">
            <table class="table stats-table ">
                <thead>
                    <tr>
                        <th>S.NO</th>
                        <th>PRODUCT</th>
                        <th>STATUS</th>
                        <th>PROGRESS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Lorem ipsum</td>
                        <td><span class="label label-success">In progress</span></td>
                        <td>
                            <h5>85% <i class="fa fa-level-up"></i></h5>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Aliquam</td>
                        <td><span class="label label-warning">New</span></td>
                        <td>
                            <h5>35% <i class="fa fa-level-up"></i></h5>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Lorem ipsum</td>
                        <td><span class="label label-danger">Overdue</span></td>
                        <td>
                            <h5 class="down">40% <i class="fa fa-level-down"></i></h5>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>Aliquam</td>
                        <td><span class="label label-info">Out of stock</span></td>
                        <td>
                            <h5>100% <i class="fa fa-level-up"></i></h5>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td>Lorem ipsum</td>
                        <td><span class="label label-success">In progress</span></td>
                        <td>
                            <h5 class="down">10% <i class="fa fa-level-down"></i></h5>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">6</th>
                        <td>Aliquam</td>
                        <td><span class="label label-warning">New</span></td>
                        <td>
                            <h5>38% <i class="fa fa-level-up"></i></h5>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>

@endsection