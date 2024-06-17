@extends("admin.layout.index")


@section("title")
<title>Cập nhật nhân viên</title>
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
            Sửa nhân viên
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('staff.update',['id'=>$staff->id])}}" style="width: 100%" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">

                       
                        <div class="form-group">
                            <label for="user_name">Tên nhân viên</label>
                            <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                                id="user_name" name="user_name" placeholder="Nhập tên vai trò"
                                value="{{$staff->user_name}}" />
                            @error('user_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="user_mobile">Số điện thoại</label>
                            <input type="number" class="form-control @error('user_mobile') is-invalid @enderror"
                                id="name" name="user_mobile" placeholder="Nhập số điện thoại"
                                value="{{$staff->user_mobile}}" />
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
                                <img src='{{$staff->user_image_url}}'/>  
                            @error('user_image_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Chọn vai trò</strong></label><br />
                            <select class="selectpicker" class="form-control @error('user_roles') is-invalid @enderror"
                                multiple data-live-search="true" name="user_roles[]">
                                @foreach($roles as $role)
                                    <option value="{{$role->role_id}}"
                                    {{  $staff->roles->contains('role_id',$role->role_id)  ? 'selected' : '' }}
                                      
                                    >{{$role->role_display_name}}</option>
                                @endforeach
                            </select>
                            @error('user_roles')
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