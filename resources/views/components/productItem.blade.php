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
                <div class="product-title text-ellipsis long-text ">
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