@extends("admin.layout.index")

@section("title")
<title>Sửa Thương hiệu</title>
@endsection
@section("content")
<div class="content">
    <div class="container-fluid">
        <div class="panel-heading" style="background:none ;">
            Sửa Thương hiệu
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('brand.update',['id'=>$brand->id])}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="brand_name">Tên thương hiệu</label>
                        <input type="text" class="form-control @error('brand_name') is-invalid @enderror"
                            value="{{$brand->brand_name}}" id="brand_name" name="brand_name"
                            placeholder="Nhập tên thương hiệu" />
                        @error('brand_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="brand_description">Mô tả thương hiệu</label>
                        <input type="text" class="form-control @error('brand_description') is-invalid @enderror"
                            value="{{$brand->brand_description}}" id="brand_description" name="brand_description"
                            placeholder="Nhập tên thương hiệu" />
                        @error('brand_description')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="brand_status">Trạng thái</label>
                        <select class="form-control" id="brand_status" name="brand_status">
                            <option value='0' {{$brand->brand_status==0&&"selected"}}>Ẩn</option>
                            <option value='1' {{$brand->brand_status==1&&"selected"}}>Hiển thị</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>

            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection