@extends("admin.layout.index")

@section("content")
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh mục sản phẩm
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
                @can(config("permission.access.add-category"))
                <button class="btn btn-sm btn-info">
                    <a href="{{route('category.add')}}" style="color:white">
                        Thêm danh mục
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
                        <th>Tên danh mục</th>
                        <th style="text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td><span class="text-ellipsis">{{$category->category_name}}</span></td>
                        <td style="display: flex; justify-content: center; gap: 30px;">
                            @can(config("permission.access.edit-category"))
                            <a href="{{route('category.edit',['id'=>$category->id])}}" class="btn btn-default">Edit</a>
                            @endcan
                            @can(config("permission.access.delete-category"))
                            <a href='' data-url="{{route('category.delete',['id'=>$category->id])}}"
                                class="btn btn-danger btn-category-delete">Remove</a>
                        </td>
                        @endcan
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            @include('components.pagination',['list'=>$categories,'title'=>'Không có danh mục nào!'])
        </footer>
    </div>
</div>

@endsection