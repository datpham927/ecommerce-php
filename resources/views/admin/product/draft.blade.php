@extends("admin.layout.index")
 

@section("content")
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách sản phẩm nháp
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
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th>Tên Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Giảm giá</th>
                        <th>Danh mục</th>
                        <th>Nhãn hàng</th>
                        <th style="text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key =>$product)
                    <tr>
                        <td><span class="text-ellipsis">{{$key+1}}</span></td>
                        <td style="display: flex;"><span
                                class="text-ellipsis long-text">{{$product->product_name}}</span></td>
                        <td><span class="text-ellipsis">{{$product->product_stock}}</span></td>
                        <td><span class="text-ellipsis">{{$product->product_price}}</span></td>
                        <td><span class="text-ellipsis">{{$product->product_discount}}</span></td>
                        <td><span class="text-ellipsis"> {{ optional($product->category)->category_name }}</span></td>
                        <td><span class="text-ellipsis"> {{ optional($product->brand)->brand_name }} </span></td>
                        <td style="display: flex; justify-content: center; gap: 20px;">
                            <a href="" data-url="{{ route('product.isPublish', ['id' => $product->id]) }}"
                                class="btn btn-danger btn-publish-product">Đăng ngay</a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="col-md-12 custom-pagination">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </footer>
    </div>
</div>

@endsection