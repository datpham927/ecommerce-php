@extends("layout.client")

@section("slider")
    @include("layout.components.slider")
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
                
                    <h2 class="title text-center">Danh mục sản phẩm</h2>

                    @foreach($products_by_categoryId as $product)
                    <div class="col-sm-3" style="padding: 12px;">
                        <a href="{{route('product.detail',['slug'=>$product->slug,'pid'=>$product->id])}}"  class="product-item" style="margin: 0 -5px ;">
                            <div class="product-top">
                                @if($product->discount > 0)
                                <san class="product-discount">{{$product->discount }}%</san>
                                @endif
                                <img src='{{$product->thumb}}' />
                            </div>
                            <div class="product-content">
                                <div class="product-title long-text">
                                    {{$product->name}}
                                </div>
                                <div class="product-price">
                                    @if($product->discount == 0)
                                    ₫{{ number_format($product->price , 0, ',', '.') }}
                                    @else
                                    <div class="product-price-old">
                                        ₫{{number_format($product->price , 0, ',', '.') }}</div>
                                    <div class="product-price-new">
                                        ₫{{number_format( $product->price - ($product->price * $product->discount / 100) , 0, ',', '.')}}
                                    </div>
                                    @endif
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <div class="product-rating">
                                        @php $rating = $product->ratings; @endphp

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
                                        Đã bán {{$product->sold}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>



@endsection