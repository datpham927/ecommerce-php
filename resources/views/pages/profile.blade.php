@extends("layout.client")

@section("body")
<div class="container " style="padding-top: 20px;">
    <div class="row">
        <div class="col-md-3 border-right " style="background-color: white;">
            <div
                style="background-color: white;padding: 20px; height:inherit; display: flex; flex-direction: column;align-items: center;">
                <img class="rounded-circle mt-5" width="150px"
                    src="{{$user->user_avatar?$user->user_name:"https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"}}">
                <span style="font-weight: 600;">{{$user->user_name}}</span>
            </div>


            <div style=" display: flex; justify-content: center;">
                <a href="{{route('order.order_list')}}" style="display: flex;align-items: center ;color: #FB5530">
                    <img src="{{asset('frontend/images/home/logo.png')}}" style="width: 30px;" />
                    Đơn hàng của bạn
                </a>
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
                            <input type="number" class="form-control" name="user_phone" placeholder="Nhập số điện thoại"
                                value="{{$user->user_phone}}">
                        </div>
                    </div>
                    <div class="row mt-3" style="margin-top: 20px;">
                        <div class="col-md-12"><label class="labels">Email</label>
                            <button type="button"
                                style="outline: none; text-align: start; background-color:#E9E9ED ; cursor: auto;border: none;"
                                class="form-control"   name="user_email">
                                {{$user->user_email}}
                            </button>

                        </div>

                    </div>
                    <div class="row mt-3" style="margin-top: 20px;">
                        <div class="col-md-12"><label class="labels">Địa chỉ</label><input type="text"
                                class="form-control" placeholder="Nhập địa chỉ" name="user_address"
                                value="{{$user->user_address}}"></div>

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