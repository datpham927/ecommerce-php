@extends("admin.layout.index")


@section("title")
<title>Cập nhật thông tin khách hàng</title>
@endsection

@section("js")
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endsection

@section("css")
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<style type="text/css">
.dropdown-toggle {
    height: 40px;
    width: 400px !important;
}
</style>
@endsection


@section("content")
<div class="content">
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
        @php
        Session::forget('success');
        @endphp
    </div>
    @endif
    <div class="container-fluid">
        <div class="panel-heading" style="background:none ;">
            Cập nhật khách hàng
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('customer.update',['id'=>$customer->id])}}" style="width: 100%" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="user_email">Nhập email</label>
                            <input type="email" class="form-control @error('user_email') is-invalid @enderror" id="name"
                                name="user_email" 
                                
                                placeholder="Nhập email" value="{{$customer->user_email}}" />
                            @error('user_email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="user_name">Tên khách hàng</label>
                            <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                                id="user_name" name="user_name" placeholder="Nhập tên vai trò"
                                value="{{$customer->user_name}}" />
                            @error('user_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row row-cols-1 row-cols-md-3 mb-3"
                            style="display: flex;justify-content: space-between;">
                            <div class="col" style="min-width: 200px; ">
                                <label for="city">Chọn thành phố</label>
                                <select class="form-control choose city"  name="city" required>
                                    <option value=''>Chọn thành phố</option>
                                    @foreach($cities as $city) 
                                    <option value='{{$city->matp}}'   {{ $customer->user_city_id === $city->matp ? 'selected' : '' }} >{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col" style="min-width: 200px; ">
                                <label for="province">Quận huyện</label>
                                <select class="form-control choose province" name="province" required>
                                @foreach($provinces as $province)
                                    <option value='{{$province->maqh}}'  {{ $customer->user_province_id === $province->maqh ? 'selected' : '' }}>{{$province->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col" style="min-width: 200px; ">
                                <label for="ward">Chọn xã phường</label>
                                <select class="form-control ward"  name="ward" required>
                                @foreach($wards as $ward)
                                    <option value='{{$ward->xaid}}'  {{ $customer->user_ward_id === $ward->xaid ? 'selected' : '' }}>{{$ward->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_mobile">Nhập số điện thoại</label>
                            <input type="number" class="form-control @error('user_mobile') is-invalid @enderror"
                                id="name" name="user_mobile" placeholder="Nhập số điện thoại"
                                value="{{$customer->user_mobile}}" />
                            @error('user_mobile')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="user_password">Mật khẩu mới</label>
                            <input type="password" class="form-control @error('user_password') is-invalid @enderror"
                                id="name" name="user_password" placeholder="Nhập mật khẩu"
                                value="" />
                            @error('user_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirm">Xác nhận mật khẩu mới</label>
                            <input type="password"
                                class="form-control @error('password_confirm') is-invalid @enderror" id="name"
                                name="password_confirm" placeholder="Xác nhận mật khẩu"
                                value="" />
                            @error('password_confirm')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group add-avatar">
                            <label for="user_image_url">
                                Chọn ảnh đại diện
                                <img src="{{asset('backend/images/image_logo2.png')}}"
                                    style='width: 30px; height: 30px;' />
                                <input type="file" class="user-avatar @error('user_image_url') is-invalid @enderror"
                                     data-url='{{route("upload_image")}}'
                                    id="user_image_url" style="display: none;" name="user_image_url" />
                            </label> 
                             
                                <img src='{{$customer->user_image_url??asset('backend/images/avatar.jpg')}}'/>  
                            @error('user_image_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

            </div>

            <div style="display: flex;  margin: auto; margin-bottom: 30px;">
                <button type="submit" class="btn btn-primary" style="width: 100px;">Cập nhật</button>
            </div>

            </form>

        </div>
        <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
</div>
@endsection