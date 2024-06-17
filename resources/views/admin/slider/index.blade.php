@extends("admin.layout.index")

@section("js")
<script type="text/javascript" src="{{asset('backend/js/slider.js')}}"></script>
@endsection

@section("content")
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách slider
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
                @can(config("permission.access.add-slider"))
                <button class="btn btn-sm btn-info">
                    <a href="{{route('slider.add')}}" style="color:white">
                        Thêm slider
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
                        <th>Tên slider</th>
                        <th>Hình ảnh</th>
                        <th style="text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $slider)
                    <tr>
                        <td>{{$slider->id}}</td>
                        <td><span class="text-ellipsis">{{$slider->slider_name}}</span></td>
                        <td>
                            <img src='{{$slider->slider_image}}' style="width: 200px;" />
                        </td>
                        <td style="display: flex; justify-content: center; gap: 30px;">
                        @can(config("permission.access.edit-slider"))  
                        <a href="{{route('slider.edit',['id'=>$slider->id])}}" class="btn btn-default">Edit</a>
                        @endcan
                        @can(config("permission.access.delete-slider"))
                        <a href='' data-url="{{route('slider.delete',['id'=>$slider->id])}}"
                                class="btn btn-danger btn-delete-slider">Remove</a>
                        </td>
                        @endcan
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="col-md-12 custom-pagination">
                {{ $sliders->links('pagination::bootstrap-4') }}
            </div>
        </footer>
    </div>
</div>

@endsection