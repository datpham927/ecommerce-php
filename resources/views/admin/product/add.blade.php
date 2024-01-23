@extends("layout.admin")


@section("title")
<title>Thêm sản phẩm</title>
@endsection

@section("js")
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{asset('backend/js/product.js')}}"></script>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
};
CKEDITOR.replace('my-editor', options);
</script>
@endsection

@section("content")
@if(Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
    @php
    Session::forget('success');
    @endphp
</div>
@endif
<div>
    <div class="panel-heading" style="background:none ;">
        Thêm danh mục
    </div>

    <form action="{{ route('product.index') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="product_name">Tên sản phẩm</label>
            <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name"
                name="product_name" placeholder="Nhập tên danh mục" />
            @error('product_name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" style="display: flex; row-gap: 20px; display: flex; flex-direction: row; gap: 20px;">
            <div style='width: 100%;'>
                <label for="parent_id">Danh mục</label>
                <select class="form-control" id="parent_id" name="parent_id">
                    <option value='0'>Chọn danh mục</option>
                </select>
            </div>
            <div style='width: 100%;'>
                <label for="parent_id">Thương hiệu</label>
                <select class="form-control" id="parent_id" name="parent_id">
                    <option value='0'>Chọn thương hiệu</option>

                </select>
            </div>
        </div>

        <div class="form-group" style="display: flex; row-gap: 20px; display: flex; flex-direction: row; gap: 20px;">
            <div class="form-group">
                <label for="product_price">Đơn giá (VNĐ)</label>
                <input type="text" class="form-control @error('product_price') is-invalid @enderror" id="product_name"
                    name="product_price" placeholder="Nhập tên danh mục" />
                @error('product_price')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="product_discount">Giảm giá (%)</label>
                <input type="text" class="form-control @error('product_discount') is-invalid @enderror"
                    id="product_name" name="product_discount" placeholder="Nhập tên danh mục" />
                @error('product_discount')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <div style="display: flex; justify-content: space-between;">
                <label for="product_name">Kích thước</label>
                <div>
                    <button type="button" id="add-size">Thêm kích thước</button>
                </div>
            </div>
            <div style="width: 100%; display: flex;; margin-bottom: 10px;  flex-direction: row; gap: 20px;">
                <h2 style="width: 50%; font-size: 14px;" for="product_size">Tên kích thước</h2>
                <h2 style="width: 50%;  font-size: 14px;" for="product_quantity">Số lượng sản phẩm</h2>
            </div>


            <div id="sizes-container">
                <div class='size-input'
                    style="display: flex;margin-top: 10px; row-gap: 20px; display: flex; flex-direction: row; gap: 20px;">
                    <div style="width: 100%;">
                        <input type="text" class="form-control @error('product_size') is-invalid @enderror"
                            id="product_size" name="product_sizes[]" placeholder="Nhập tên danh mục" />
                        @error('product_size')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div style="width: 100%;">
                        <input type="text" class="form-control @error('product_quantity') is-invalid @enderror"
                            id="product_quantity" name="product_quantities[]" placeholder="Nhập tên danh mục" />
                        @error('product_discount')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="form-group" style="margin-top: 20px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between;">
                    <label for="product_name">Chi tiết sản phẩm</label>
                    <div>
                        <button type="button" id="add-size">Thêm thuộc tính</button>
                    </div>
                </div>
                <div style="width: 100%; display: flex;; margin-bottom: 10px;  flex-direction: row; gap: 20px;">
                    <h2 style="width: 50%; font-size: 14px;" for="product_size">Tên thuộc tính</h2>
                    <h2 style="width: 50%;  font-size: 14px;" for="product_quantity">Mô tả</h2>
                </div>

                <div id="attributes-container">
                    <div class='attribute-input'
                        style="display: flex;margin-top: 10px; row-gap: 20px; display: flex; flex-direction: row; gap: 20px;">
                        <div style="width: 100%;">
                            <input type="text" class="form-control @error('product_size') is-invalid @enderror"
                                id="product_size" name="product_sizes[]" placeholder="Nhập tên danh mục" />
                            @error('product_size')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div style="width: 100%;">
                            <input type="text" class="form-control @error('product_quantity') is-invalid @enderror"
                                id="product_quantity" name="product_quantities[]" placeholder="Nhập tên danh mục" />
                            @error('product_discount')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 30px;">
                    <label for="category_description" style="margin-bottom: 10px;">Mô tả sản phẩm</label>
                    <textarea id="my-editor" name="category_description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="product_thumb">
                        Thêm hình ảnh
                        <img src="{{asset('backend/images/image_logo2.png')}}" style='width: 30px; height: 30px;' />
                        <input id="product_thumb" type="file" multiple style="display: none;" />
                    </label>
                </div>
                <div class="form-group">
                    <label for="product_images">
                        Thêm nhiều hình ảnh
                        <img src="{{asset('backend/images/image_logo.png')}}" style='width: 30px; height: 30px;' />
                        <input id="product_images" type="file" name="product_images[]" multiple
                            style="display: none;" />
                    </label>
                </div>
            </div>


            <div style="display: flex; justify-content: end;flex-direction: row; gap: 20px; ">
                <button type="button" class="btn btn-primary">Bản nháp</button>
                <button type="submit" class="btn btn-success">Thêm</button>
            </div>
    </form>
</div>

@endsection