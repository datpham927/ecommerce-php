@extends("layout.client.index")


@section("footer")
@include("layout.client.components.footer")
@endsection


@section("body")
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include("layout.client.components.sidebar")
            </div>
            <div class="col-sm-9 padding-right">
                @if(count($products_by_brandId)>0)
                <div class="features_items">
                    <!--features_items-->
                    <!-- <h2 class="title text-center">Features Items</h2> -->
                    @foreach($products_by_brandId as $product)
                       @include('components.productItem',['comment'=>$product])
                   </div>
                @endforeach
            </div>

            @else
            <div style="display: flex; flex-direction: column; align-items: center;">
                <img style='width: 200px;'
                    src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f4.png" />
                <span style="margin: 10px 0; font-size: 20px;">Không có sản phẩm nào</span>

            </div>
            @endif
        </div>
    </div>

    </div>
    </div>
</section> 

@endsection