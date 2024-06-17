@extends("admin.layout.index")

@section("content")
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách người dùng (admin)
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-7 m-b-xs">
                <form action="{{ url()->current() }}" method="GET" class="col-sm-12 m-b-xs" style="display: flex;">
                    <div class="col-sm-6" style="display: flex; justify-items: center; text-align: center;">
                        <input type="text" name='name' value="{{ $staffName ?? '' }}" class="input-sm form-control"
                            style="margin-right: 20px;" placeholder="Nhập tên cần tìm kiếm">
                    </div>
                    <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                </form>
            </div>
            <div class="col-sm-2">
            </div>
            <div class="col-sm-3">
                @can(config("permission.access.add-staff"))
                <button class="btn btn-sm btn-info">
                    <a href="{{route('staff.add')}}" style="color:white">
                        Thêm nhân viên
                    </a>
                </button>
                @endcan
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th style="text-align: center;">ID</th>
                        <th style="text-align: center;">Hình ảnh</th>
                        <th style="text-align: center;">Tên người dùng</th>
                        <th style="text-align: center;">Vai trò</th>
                        <th style="text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user_staffs as $staff)
                    <tr>
                        <td style="text-align: center;">{{$staff->id}}</td>
                        <td style="text-align: center;">
                            <img style="width: 40px; border-radius: 4px;" src="{{$staff->user_image_url}}" />
                        </td>
                        <td style="text-align: center;"><span class="text-ellipsis">{{$staff->user_name}}</span></td>
                        <td style="text-align: center;">
                            @foreach($staff->roles as $role)
                            <span class="text-ellipsis">{{$role->role_display_name}}</span>
                            <br />
                            @endforeach

                        </td>
                        <td style="display: flex; justify-content: center; gap: 30px;">
                            @can(config("permission.access.edit-staff"))
                            <a href="{{route('staff.edit',['id'=>$staff->id])}}" class="btn btn-default">Edit</a>
                            @endcan
                            @can(config("permission.access.delete-staff"))
                            <a href='' data-url="{{route('staff.delete',['id'=>$staff->id])}}"
                                class="btn btn-danger btn-delete-staff">Remove</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            @include('components.pagination',['list'=>$user_staffs,'title'=>'Không có nhân viên nào!'])
        </footer>
    </div>
</div>

@endsection