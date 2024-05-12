@extends("layout.admin")


@section("title")
<title>Thêm nhân viên</title>
@endsection

@section("js")
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<!-- Initialize the plugin: -->
<script type="text/javascript">
$(document).ready(function() {
    $('select').selectpicker();
});
</script>

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
            Thêm nhân viên
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('staff.store')}}" style="width: 100%" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="admin_name">Nhập tên đăng nhập</label>
                            <input type="text" class="form-control @error('admin_name') is-invalid @enderror" id="name"
                                name="admin_name" placeholder="Nhập tên" value="{{old('admin_name')}}" />
                            @error('admin_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="admin_address">Địa chỉ</label>
                            <input type="text" class="form-control @error('admin_address') is-invalid @enderror"
                                id="admin_address" name="admin_address" placeholder="Nhập Địa chỉ"
                                value="{{old('admin_address')}}" />
                            @error('admin_address')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="admin_mobile">Nhập số điện thoại</label>
                            <input type="number" class="form-control @error('admin_mobile') is-invalid @enderror"
                                id="name" name="admin_mobile" placeholder="Nhập số điện thoại"
                                value="{{old('admin_mobile')}}" />
                            @error('admin_mobile')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="admin_cmnd">Nhập số cmnd</label>
                            <input type="number" class="form-control @error('admin_cmnd') is-invalid @enderror"
                                id="name" name="admin_cmnd" placeholder="Nhập số cmnd"
                                value="{{old('admin_cmnd')}}" />
                            @error('admin_cmnd')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="admin_password">Nhập mật khẩu</label>
                            <input type="password" class="form-control @error('admin_password') is-invalid @enderror"
                                id="name" name="admin_password" placeholder="Nhập mật khẩu"
                                value="{{old('admin_password')}}" />
                            @error('admin_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirm">Xác nhận mật khẩu</label>
                            <input type="password_confirm"
                                class="form-control @error('password_confirm') is-invalid @enderror" id="name"
                                name="password_confirm" placeholder="Xác nhận mật khẩu"
                                value="{{old('password_confirm')}}" />
                            @error('password_confirm')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group add-avatar">
                            <label for="admin_image_url">
                                Chọn ảnh đại diện
                                <img src="{{asset('backend/images/image_logo2.png')}}"
                                    style='width: 30px; height: 30px;' />
                                <input type="file" class="user-avatar @error('admin_image_url') is-invalid @enderror"
                                    value="{{old('admin_image_url')}}" data-url='{{route("staff.upload_image")}}'
                                    id="admin_image_url" style="display: none;" name="admin_image_url" />
                            </label>
                            <img src='{{asset('backend/images/avatar.jpg')}}'/>
                            @error('admin_image_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Chọn vai trò</strong></label><br />
                            <select class="selectpicker" class="form-control @error('admin_roles') is-invalid @enderror"
                                multiple data-live-search="true" name="admin_roles[]">
                                @foreach($roles as $role)
                                <option value="{{$role->role_id}}">{{$role->role_display_name}}</option>
                                @endforeach
                            </select>
                            @error('admin_roles')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

            </div>

            <div style="display: flex;  margin: auto; margin-bottom: 30px;">
                <button type="submit" class="btn btn-primary" style="width: 100px;">Thêm</button>
            </div>

            </form>

        </div>
        <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
</div>
@endsection