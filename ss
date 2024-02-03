.long-text {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    -webkit-line-clamp: 2
}

.product-item {
    background-color: white;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 0.0625rem 0.125rem 0px;
}

.product-item:hover {
    box-shadow: rgba(0, 0, 0, 0.05) 0px 0.0625rem 20px 0px;
    transform: translateY(-0.0625rem);
    z-index: 1
}

.product-top {
    width: 100%;
    position: relative;
}

.product-discount {
    position: absolute;
    right: 0;
    top: 0;
    background-color: #ffe97a;
    color: #ec3814;
    padding: 0 10px;
    font-size: 12px;
    border-bottom-left-radius: 2px;
}

.product-top img {
    width: 100%;
    display: block;
}

.product-content {
    padding: 4px 8px;
}

.product-title {
    font-size: 13px;
    color: rgba(0, 0, 0, 0.87);
}

.product-price {
    display: flex;
    margin: 5px 0;
    gap: 10px;
    color: #ee4d2d;
}

.product-price-old {
    color: rgba(0, 0, 0, .54);
    text-decoration: line-through;
}

.product-rating {
    color: gold;
    font-size: 10px;
}

.product-sold {
    font-size: 13px;
    color: rgba(0, 0, 0, .87);
}

@foreach($products as $product) <div class="col-lg-3 col-sm-3"><div class="product-item" style="margin: 0 -5px
;
">
 <div class="product-top">@if($product->product_discount > 0) <san class="product-discount"> {
    {
        $product->product_discount
    }
}

%</san>@endif <img src='{{$product->product_thumb}}' /></div><div class="product-content"><div class="product-title long-text"> {
    {
        $product->product_name
    }
}

</div><div class="product-price">@if($product->product_discount==0) ₫ {
    {
        number_format($product->product_price, 0, ',', '.')
    }
}

@else <div class="product-price-old">₫ {
    {
        number_format($product->product_price, 0, ',', '.')
    }
}

</div><div class="product-price-new">₫ {
    {
        number_format( $product->product_price - ($product->product_price * $product->product_discount / 100), 0, ',', '.')
    }
}

</div>@endif </div><div class="product-rating">@php $rating=$product->product_ratings;
@endphp @foreach(range(1, 5) as $i) <span class="fa-stack" style="width:1em"><i class="far fa-star fa-stack-1x"></i>@if($rating >0) @if($rating >0.5) <i class="fas fa-star fa-stack-1x"></i>@else <i class="fas fa-star-half fa-stack-1x"></i>@endif @endif @php $rating--;
@endphp </span>@endforeach