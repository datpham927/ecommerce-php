@php
use App\Models\setting;
$setting = setting::first();
@endphp
<div class="footer-widget">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="single-widget">
                    <h2>Thông tin liên hệ</h2>
                    <ul class="nav nav-pills nav-stacked">
                        @if(!empty($setting->setting_address))
                        <li><span>{{$setting->setting_address}}</span></li>
                        @endif
                        @if(!empty($setting->setting_phone))
                        <li><span>{{$setting->setting_phone}}</span></li>
                        @endif
                        @if(!empty($setting->setting_email))
                        <li><span>{{$setting->setting_email}}</span></li>
                        @endif
                    </ul>

                </div>
            </div>
            <div class="col-sm-4">
                <div class="single-widget">
                    <h2>Thông tin chung</h2>
                    <ul class="nav nav-pills nav-stacked">
                        @if(!empty($setting->setting_logo))
                        <li><img src="{{$setting->setting_logo}}" style="width: 100px;height: 100px;" /></li>
                        @endif
                        @if(!empty($setting->setting_company_name))
                        <li><span>{{$setting->setting_company_name}}</span></li>
                        @endif
                        @if(!empty($setting->setting_slogan))
                        <li><span>{{$setting->setting_slogan}}</span></li>
                        @endif
                    </ul>

                </div>
            </div>
            <div class="col-sm-4">
                @if(!empty($setting->setting_map))
                <div class="single-widget">
                    <h2>Bản đồ</h2>
                    <ul class="nav nav-pills nav-stacked">
                        <li>
                            {!!$setting->setting_map!!}
                        </li>

                    </ul>
                </div>
                @endif
            </div>
        </div>


    </div>
</div>

<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
            <p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span>
            </p>
        </div>
    </div>
</div>

</footer>