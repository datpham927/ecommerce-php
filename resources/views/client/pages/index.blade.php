@extends("client.layout.index")

@section('js')
<script src="{{asset('frontend/js/address.js')}}"></script>
@endsection

@section("body")
<div class="container " style="padding-top: 20px;">
    <div class="row">
        <div class="col-md-3 border-right " style="background-color: white;">
            <div
                style="background-color: white;padding: 20px; height:inherit; display: flex; flex-direction: column;align-items: center;">
                <img class="rounded-circle mt-5" width="150px"style="border-radius:100%"
                    src="{{$user->user_image_url??"https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"}}">
                <span style="font-weight: 600;margin-top: 10px;">{{$user->user_name}}</span>
            </div>


            <div style=" display: flex; justify-content: center;">
             @if( Auth::check()&&Auth::user()->user_type=='customer')
                <a href="{{route('order.order_list')}}" style="display: flex;align-items: center ;color: #FB5530">
                    <img src="{{asset('frontend/images/home/logo.png')}}" style="width: 30px;" />
                    Đơn hàng của bạn
                </a>
                @else
                <a href="{{route('admin.dashboard')}}" style="display: flex;align-items: center ;color: #FB5530">
                    <img src="{{asset('frontend/images/home/logo.png')}}" style="width: 30px;" />
                   Trang quản lý
                </a>
                @endif
            </div>
            <div style="display: flex; justify-content: center; margin: 10px 0; margin-top: 30px">
                <a href="{{route('user.logout')}}" class="btn btn-primary profile-button" style="border-radius: 2px;">
                    Đăng xuất
                </a>

            </div>

        </div>
        <div class="col-md-9 border-right">
            <form action="{{route('user.update')}}" method="post">
                @csrf
                <div style="background-color: white; padding: 20px;">
                    <div class="row mt-2" style="margin-top: 20px;">
                        <div class="col-md-6"><label class="labels">Tên</label>
                            <input type="text" required class="form-control" placeholder="Nhập tên" name="user_name"
                                value="{{$user->user_name}}">
                        </div>
                        <div class="col-md-6"><label class="Số điện thoại">Số điện thoại</label>
                            <input type="number" class="form-control" name="user_mobile"
                                placeholder="Nhập số điện thoại" value="{{$user->user_mobile}}">
                        </div>
                    </div>
                    <div class="row mt-3" style="margin-top: 20px;">
                        <div class="col-md-12"><label class="labels">Email</label>
                            <button type="button"
                                style="outline: none; text-align: start; background-color:#E9E9ED ; cursor: auto;border: none;"
                                class="form-control" name="user_email">
                                {{$user->user_email}}
                            </button>

                        </div>
                    </div>
                    <div class="row mt-3" style="margin-top: 20px;">
                    <div class="row row-cols-1 row-cols-md-3 mb-3"
                            style="display: flex;justify-content: space-between;">
                            <div class="col" style="min-width: 200px; ">
                                <label for="city">Chọn thành phố</label>
                                <select class="form-control choose city"   name="city" required>
                                    <option value=''>Chọn thành phố</option>
                                    @foreach($cities as $city) 
                                    <option value='{{$city->matp}}'   {{ $user->user_city_id === $city->matp ? 'selected' : '' }} >{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col" style="min-width: 200px; ">
                                <label for="province">Quận huyện</label>
                                <select class="form-control choose province"  name="province" required>
                                @foreach($provinces as $province)
                                    <option value='{{$province->maqh}}'  {{ $user->user_province_id === $province->maqh ? 'selected' : '' }}>{{$province->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col" style="min-width: 200px; ">
                                <label for="ward">Chọn xã phường</label>
                                <select class="form-control ward"  name="ward" required>
                                @foreach($wards as $ward)
                                    <option value='{{$ward->xaid}}'  {{ $user->user_ward_id === $ward->xaid ? 'selected' : '' }}>{{$ward->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center" style="margin-top: 30px;  ">
                        <button class="btn btn-primary profile-button" type="submit"
                            style="padding: 10px 40px; border-radius: 2px">
                            Cập nhật
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection


