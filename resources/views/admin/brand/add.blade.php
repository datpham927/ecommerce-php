@extends("admin.layout.index")

@section("title")
<title>Thêm thương hiệu</title>
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
            Thêm thương hiệu
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('brand.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="brand_name">Tên thương hiệu</label>
                        <input type="text" class="form-control @error('brand_name') is-invalid @enderror"
                            id="brand_name" name="brand_name" placeholder="Nhập tên thương hiệu" />
                        @error('brand_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="brand_description">Mô tả thương hiệu</label>
                        <input type="text" class="form-control @error('brand_description') is-invalid @enderror"
                            id="brand_description" name="brand_description" placeholder="Nhập tên thương hiệu" />
                        @error('brand_description')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="brand_status">Trạng thái</label>
                        <select class="form-control" id="brand_status" name="brand_status">
                            <option value='0'>Hiển thị</option>
                            <option value='1'>Ẩn</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>

            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection