@extends("admin.layout.index")


@section("title")
<title>Chỉnh sửa sản phẩm</title>
@endsection

@section("js")
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
        Chỉnh sửa sản phẩm
    </div>

    <form action="{{route('product.update',['id'=>$product->id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="product_name">Tên sản phẩm</label>
            <input value="{{$product->product_name}}" type="text"
                class="form-control @error('product_name') is-invalid @enderror" 
                name="product_name" />
            @error('product_name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" style="display: flex; row-gap: 20px; display: flex; flex-direction: row; gap: 20px;">
            <div style='width: 100%;'>
                <label for="product_category_id">Danh mục</label>
                <select class="form-control @error('product_category_id') is-invalid @enderror" id="product_category_id"
                    name="product_category_id">
                    <option value='-1'>Chọn danh mục</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $product->product_category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                    @endforeach

                </select>
                @error('product_category_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div style='width: 100%;'>
                <label for="product_brand_id">Thương hiệu</label>
                <select value="{{old('product_brand_id')}}"
                    class="form-control @error('product_brand_id') is-invalid @enderror" id="product_brand_id"
                    name="product_brand_id">
                    <option value='-1'>Chọn thương hiệu</option>
                    @foreach($brands as $brand)
                    <option value='{{ $brand->id }}' {{ $brand->id == $product->product_brand_id ? 'selected' : '' }}>
                        {{ $brand->brand_name }}
                    </option>
                    @endforeach
                </select>
                @error('product_brand_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group" style="display: flex; row-gap: 20px; display: flex; flex-direction: row; gap: 20px;">
            <div class="form-group">
                <label for="product_origin_price">Giá gốc (VNĐ)</label>
                <input value="{{$product->product_origin_price}}" type="number"
                    class="form-control @error('product_origin_price') is-invalid @enderror" 
                    name="product_origin_price" />
                @error('product_origin_price')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="product_price">Giá bán (VNĐ)</label>
                <input value="{{$product->product_price}}" type="number"
                    class="form-control @error('product_price') is-invalid @enderror"  
                    name="product_price" />
                @error('product_price')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="product_discount">Giảm giá (%)</label>
                <input value="{{$product->product_discount}}" type="number" class="form-control" 
                    name="product_discount" />
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
                <h2 style="width: 50%;  font-size: 14px;" for="product_stock">Số lượng sản phẩm</h2>
            </div>
            <div id="sizes-container">
                @foreach($sizes as $size)
                <div class='size-input'
                    style="display: flex;margin-top: 10px; row-gap: 20px; display: flex; flex-direction: row; gap: 20px;">
                    <div style="display: flex; width: 100%; gap:20px ;  height: 100%;">
                        <div style="width: 100%;">
                            <input type="text" value="{{$size->size_name}}" required
                                class="form-control @error('product_sizes') is-invalid @enderror" id="product_sizes"
                                name="product_sizes[]" />
                            @error('product_sizes')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div style="width: 100%;">
                            <input type="number" value="{{$size->size_product_quantity}}" required
                                class="form-control @error('product_quantities') is-invalid @enderror"
                                id="product_quantities" name="product_quantities[]" />
                            @error('product_quantities')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div style="display: flex; height: 100%; margin: auto ; cursor: pointer;" class='remove_input_size'>
                        <span> <i class="fa fa-times" aria-hidden="true"></i></span>
                    </div>

                </div>
                @endforeach
            </div>


            <div class="form-group" style="margin-top: 20px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between;">
                    <label for="product_name">Chi tiết sản phẩm</label>
                    <div>
                        <button type="button" id="add-attribute">Thêm thuộc tính</button>
                    </div>
                </div>
                <div style="width: 100%; display: flex;; margin-bottom: 10px;  flex-direction: row; gap: 20px;">
                    <h2 style="width: 50%; font-size: 14px;" for="product_attribute">Tên thuộc tính</h2>
                    <h2 style="width: 50%;  font-size: 14px;" for="product_stock">Mô tả</h2>
                </div>

                <div id="attributes-container">
                    @foreach($attributes as $attribute)

                    <div class='attribute-input'
                        style="display: flex;margin-top: 10px; row-gap: 20px; display: flex; flex-direction: row; gap: 20px;">
                        <div style="display: flex; width: 100%; gap:20px ;  height: 100%;">
                            <div style="width: 100%;">
                                <input type="text" value="{{$attribute->attribute_name}}"
                                    class="form-control @error('product_attribute_keys') is-invalid @enderror"
                                    id="product_attribute_keys" name="product_attribute_keys[]" />
                                @error('product_attribute_keys')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div style="width: 100%;">
                                <input type="text" value="{{$attribute->attribute_description}}"
                                    class="form-control @error('product_attribute_names') is-invalid @enderror"
                                    id="product_attribute_names" name="product_attribute_names[]" />
                                @error('product_attribute_names')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div style="display: flex; height: 100%; margin: auto ; cursor: pointer;"
                            class='remove_input_attribute'>
                            <span> <i class="fa fa-times" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="form-group" style="margin-top: 30px;">
                    <label for="product_description" style="margin-bottom: 10px;">Mô tả sản phẩm</label>
                    <textarea id="my-editor" name="product_description"
                        class="form-control  @error('product_description') is-invalid @enderror">{{$product->product_description}}</textarea>
                    @error('product_description')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="product_thumb">
                    Thêm hình ảnh
                    <img src="{{asset('backend/images/image_logo2.png')}}" style='width: 30px; height: 30px;' />
                    <input type="file" class="@error('product_thumb') is-invalid @enderror"
                        value="{{old('product_thumb')}}" id="product_thumb" style="display: none;"
                        name="product_thumb" />
                </label>
                <div>
                    <img hight="40px" width="40px" src="{{$product->product_thumb}}" />
                </div>
                @error('product_thumb')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="product_images">
                    Thêm nhiều hình ảnh
                    <img src="{{asset('backend/images/image_logo.png')}}" style='width: 30px; height: 30px;' />
                    <input value="{{old('product_images')}}" class="@error('product_images') is-invalid @enderror"
                        id="product_images" type="file" name="product_images[]" multiple style="display: none;" />
                </label>
                <div style="display: flex; gap:20px">
                    @foreach($images as $image)
                    <img hight="40px" width="40px" src="{{$image->image_url}}" />
                    @endforeach
                    </ul>

                    @error('product_images')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <input id="product_isDraft" name='product_isDraft' type="checkbox" {{$product->isDraft?"checked":""}}
                    class="btn btn-primary" />
                <label for="product_isDraft">Bản nháp</label>
            </div>
        </div>


        <div style="display: flex; justify-content: end;flex-direction: row; gap: 20px; ">
            <button type="submit" class="btn btn-success">Cập nhật</button>
        </div>
    </form>
</div>

@endsection