@extends("layout.client")


@section("footer")
@include("layout.components.footer")
@endsection


@section("body")
<section>
    <div class="container">
        <div class="row">
            <h2 style="font-weight: 400; margin-left: 20px; font-size: 20px;">Kết quả tìm kiếm "{{$query}}"</h2>
            @if(count($products)>0)
            <div class="features_items">
                <!--features_items-->
                <!-- <h2 class="title text-center">Features Items</h2> -->
                @foreach($products as $product)
                <div class="col-sm-3" style="padding: 12px;">
                    <div class="product-item" style="margin: 0 -5px ;">
                        <a href="{{route('product.detail',['slug'=>$product->product_slug,'pid'=>$product->id])}}">
                            <div class="product-top">
                                @if($product->product_discount > 0)
                                <san class="product-discount">{{$product->product_discount }}%</san>
                                @endif
                                <img src='{{$product->product_thumb}}' />
                            </div>
                            <div class="product-content">
                                <div class="product-title long-text">
                                    {{$product->product_name}}
                                </div>
                                <div class="product-price">
                                    @if($product->product_discount == 0)
                                    ₫{{ number_format($product->product_price , 0, ',', '.') }}
                                    @else
                                    <div class="product-price-old">
                                        ₫{{number_format($product->product_price , 0, ',', '.') }}</div>
                                    <div class="product-price-new">
                                        ₫{{number_format( $product->product_price - ($product->product_price * $product->product_discount / 100) , 0, ',', '.')}}
                                    </div>
                                    @endif
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <div class="product-rating">
                                        @php $rating = $product->product_ratings; @endphp

                                        @foreach(range(1,5) as $i)
                                        <span class="fa-stack" style="width:1em">
                                            <i class="far fa-star fa-stack-1x"></i>

                                            @if($rating >0)
                                            @if($rating >0.5)
                                            <i class="fas fa-star fa-stack-1x"></i>
                                            @else
                                            <i class="fas fa-star-half fa-stack-1x"></i>
                                            @endif
                                            @endif
                                            @php $rating--; @endphp
                                        </span>
                                        @endforeach

                                    </div>
                                    <div class="product-sold">
                                        Đã bán {{$product->product_sold}}
                                    </div>
                                </div>
                            </div>
                    </div>
                    </a>

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
</section>



@endsection