@extends("admin.layout.index")


@section("title")
<title>Thêm vai trò</title>
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
            Thêm vai trò
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('role.store')}}" style="width: 100%" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="role_name">Tên vai trò</label>
                            <input type="text" class="form-control @error('role_name') is-invalid @enderror"
                                id="role_name" name="role_name" placeholder="Nhập tên vai trò"
                                value="{{old('role_name')}}" />
                            @error('role_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role_display_name">Mô tả vai trò</label>
                            <input type="text" class="form-control @error('role_display_name') is-invalid @enderror"
                                id="name" name="role_display_name" placeholder="Nhập tên mô tả vai trò"
                                value="{{old('role_display_name')}}" />
                            @error('role_display_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="custom-control custom-checkbox overflow-checkbox" style="margin: 10px 0;">
                            <input type="checkbox" class="custom-control-input checked-all" style="margin: 0 5px 0 0;">
                            <span class="custom-control-description overflow-control-description">Chọn tất cả</span>
                        </label>
                        @foreach($permissionParents as $permission)
                        <div class="card mb-3" style="width: 100%;">
                            <div class="card-header">
                                <div class="custom-control custom-checkbox">
                                    Module {{$permission->pms_display_name}}
                                </div>
                            </div>
                            <div class="card-body" style="display: flex; justify-content: space-between;">
                                @foreach($permission->permissionChildren as $item)
                                <label class="custom-control custom-checkbox overflow-checkbox">
                                    <input type="checkbox" value="{{$item->pms_id}}"
                                        class="custom-control-input checkbox_children" name="permission_id[]">
                                    <span
                                        class="custom-control-description overflow-control-description">{{$item->pms_display_name}}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection