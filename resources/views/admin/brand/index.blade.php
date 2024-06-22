@extends("admin.layout.index")

@section("js")
<script type="text/javascript" src="{{asset('backend/js/brand.js')}}"></script>
@endsection

@section("content")
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách thương hiệu
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">Tìm kiếm</button>
                    </span>
                </div>
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-3">
                @can(config("permission.access.add-brand"))
                <button class="btn btn-sm btn-info">
                    <a href="{{route('brand.add')}}" style="color:white">
                        Thêm thương hiệu
                    </a>
                </button>
                @endcan
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên thương hiệu</th>
                        <th>Trạng thái</th>
                        <th style="text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $brand)
                    <tr>
                        <td>{{$brand->id}}</td>
                        <td><span class="text-ellipsis">{{$brand->brand_name}}</span></td>
                        <td>
                            <span class="text-ellipsis">
                                {{$brand->brand_status==1?"Hoạt động":"Không hoạt động"}}
                            </span>
                        </td>
                        <td style="display: flex; justify-content: center; gap: 30px;">
                            @can(config("permission.access.edit-brand"))
                            <a href="{{route('brand.edit',['id'=>$brand->id])}}" class="btn btn-default">Edit</a>
                            @endcan
                            @can(config("permission.access.delete-brand"))
                            <a href='' data-url="{{route('brand.delete',['id'=>$brand->id])}}"
                                class="btn btn-danger btn-delete-brand">Remove</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            @include('components.pagination',['list'=>$brands,'title'=>'Không có nhãn hàng nào!'])
        </footer>
    </div>
</div>

@endsection