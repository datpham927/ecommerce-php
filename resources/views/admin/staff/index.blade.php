@extends("layout.admin")

@section("content")
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách người dùng (admin)
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-3">
                <button class="btn btn-sm btn-info">
                    <a href="{{route('staff.add')}}" style="color:white">
                        Thêm nhân viên
                    </a>
                </button>
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
                    @foreach($admin_staffs as $staff)
                    <tr>
                        <td style="text-align: center;" >{{$staff->id}}</td>
                        <td style="text-align: center;">
                            <img style="width: 40px; border-radius: 4px;" src="{{$staff->admin_image_url}}" />
                        </td>
                        <td style="text-align: center;"><span class="text-ellipsis">{{$staff->admin_name}}</span></td>
                        <td style="text-align: center;">
                             @foreach($staff->roles as $role)
                                <span class="text-ellipsis">{{$role->role_display_name}}</span>
                                <br/>
                            @endforeach

                        </td>
                        <td style="display: flex; justify-content: center; gap: 30px;">
                            <a href="{{route('staff.edit',['id'=>$staff->id])}}" class="btn btn-default">Edit</a>
                            <a href='' data-url="{{route('staff.delete',['id'=>$staff->id])}}"
                                class="btn btn-danger btn-delete-staff">Remove</a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="col-md-12 custom-pagination">
                {{ $admin_staffs ->links('pagination::bootstrap-4') }}
            </div>
        </footer>
    </div>
</div>

@endsection