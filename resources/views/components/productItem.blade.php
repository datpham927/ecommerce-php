<div class="{{ $col ?? 'col-sm-3' }}" style="padding: 12px;">
    <div class="product-item" style="margin: 0 -5px ;">
        <a href="{{route('product.detail',['slug'=>$product->product_slug,'pid'=>$product->id])}}">
            <div class="product-top">
                @if($product->product_discount > 0)
                <san class="product-discount">{{$product->product_discount }}%</san>
                @endif
                <img src='{{$product->product_thumb}}' alt="" />
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
                    @php $rating = $product->product_ratings; @endphp
                    @include("utils.formatRating",['rating'=>$rating])
                    <div class="product-sold">
                        Đã bán {{$product->product_sold}}
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>