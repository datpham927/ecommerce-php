@extends("client.layout.index")

@section("footer")
    @include("client.layout.components.footer")
@endsection

@section("body")
<section>
    <div class="container">
        @include("client.components.breadcrumb")
        <div class="row">
            <div class="col-sm-3">
                @include("client.layout.components.sidebar")
            </div>
            <div class="col-sm-9">
                @if(count($products_by_brandId) > 0)
                        @foreach($products_by_brandId as $product)
                            @include('client.components.productItem')
                        @endforeach
                @else
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <img style='width: 200px;' src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f4.png" />
                        <span style="margin: 10px 0; font-size: 20px;">Không có sản phẩm nào</span>
                    </div>
                @endif
            @include('components.pagination',['list'=>$products_by_brandId,'title'=>'Không có sản phẩm nào!'])
            </div>
        </div>
    </div>
</section>
@endsection
