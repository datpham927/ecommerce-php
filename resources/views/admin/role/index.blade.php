@extends("admin.layout.index") 

@section("content")
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách vai trò
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-3">
                <button class="btn btn-sm btn-info">
                    <a href="{{route('role.add')}}" style="color:white">
                        Thêm vai trò
                    </a>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên vai trò</th>
                        <th style="text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{$role->role_id}}</td>
                        <td><span class="text-ellipsis">{{$role->role_display_name}}</span></td>
                         
                        <td style="display: flex; justify-content: center; gap: 30px;">
                            <a href="{{route('role.edit',['id'=>$role->role_id])}}" class="btn btn-default">Edit</a>
                            <a href='' data-url="{{route('role.delete',['id'=>$role->role_id])}}" 
                                class="btn btn-danger btn-delete-role">Remove</a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            @include('components.pagination',['list'=>$roles,'title'=>'Không có vai trò nào!'])
        </footer>
    </div>
</div>

@endsection