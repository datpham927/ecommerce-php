@extends("admin.layout.index")

@section("title")
<title>Sửa danh mục</title>
@endsection
@section("content")
<div class="content">
    <div class="container-fluid">
        <div class="panel-heading" style="background:none ;">
            Sửa danh mục
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('category.update',['id'=>$category->id])}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="category_name">Tên danh mục</label>
                        <input type="text" class="form-control  @error('category_name') is-invalid @enderror" id="category_name" name="category_name"
                            value='{{$category->category_name}}' placeholder="Nhập tên danh mục" />
                        @error('category_name')
                        <div class="alert alert-danger ">{{ $message }}</div>
                        @enderror
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