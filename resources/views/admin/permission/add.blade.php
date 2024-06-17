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
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('permission.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="pms_name" style="margin: 10px 0;">Thêm Permission</label>
                        <select class="form-control @error('pms_name') is-invalid @enderror" name="pms_name">
                            <option value=''>Chọn quyền</option>
                            @foreach(config("permission.table_module") as $moduleItem)
                            <option value='{{$moduleItem}}'>{{$moduleItem}}</option>
                            @endforeach
                        </select>
                        @error('pms_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="form-group" style="display: flex; justify-content: space-between;">
                        @foreach(config("permission.module_children") as $childrenItem)
                        <div>
                            <label>
                                <input name="module_children[]" value="{{$childrenItem}}" type="checkbox" />
                                {{$childrenItem}}</label>
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
</div>
@endsection