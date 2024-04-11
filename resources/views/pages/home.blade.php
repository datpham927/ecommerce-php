@extends("layout.client")

@section("slider")
@include("layout.components.slider")
@endsection

@section("footer")
@include("layout.components.footer")
@endsection



@section("body")
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include("layout.components.sidebar")
            </div>
            <div class="col-sm-9 padding-right">
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
                <!--features_items-->
                <div class="recommended_items" style="margin: 30px 0">
                    <!--recommended_items-->
                 <div style="width: 100%; padding: 0 10px;">
                 <h2 class="title" style="margin: 0;">Sản phẩm mới</h2>
                 </div>

                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($newProducts->chunk(4) as $itemProducts)
                            <div class="item {{ $loop->first ? 'active' : '' }}">
                                @foreach($itemProducts as $product)
                                <div class="col-sm-3" style="padding: 12px;">
                                    <div class="product-item" style="margin: 0 -5px ;">
                                        <a
                                            href="{{route('product.detail',['slug'=>$product->product_slug,'pid'=>$product->id])}}">
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

                            @endforeach
                        </div>

                        @if(count($newProducts)>4)
                        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <!--/recommended_items-->

            </div>

        </div>
    </div>
</section>



@endsection