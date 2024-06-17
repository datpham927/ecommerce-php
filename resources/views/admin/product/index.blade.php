@extends("admin.layout.index")


@section("content")
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách sản phẩm
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-9 m-b-xs">
                <form action="{{ url()->current() }}" method="GET" class="col-sm-12 m-b-xs" style="display: flex;">
                    <div class="col-sm-6" style="display: flex; justify-items: center; text-align: center;">
                        <input type="text" name='name' value="{{ $productName ?? '' }}" class="input-sm form-control"
                            style="margin-right: 20px;" placeholder="Nhập tên sản phẩm cần tìm kiếm">
                    </div>
                    <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                </form>
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
                    @foreach($products as $key => $product)
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
                            @can(config("permission.access.edit-product"))
                            <a href="{{route('product.edit',['id'=>$product->id])}}" class="btn btn-default">Edit</a>
                            @endcan
                            @can(config("permission.access.delete-product"))
                            <a url='' data-url="{{route('product.delete',['id'=>$product->id])}}"
                                class="btn btn-danger btn-delete-product">Remove</a>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            @include('components.pagination',['list'=>$products,'title'=>'Không có sản phẩm nào!'])
        </footer>
    </div>
</div>

@endsection