@if(count($relatedProducts) > 0)
    <div class="container" style="background-color: white; margin-top: 20px;padding: 20px;">
        <div style="width: 100%;">
            <h1 class="title" style="width: 100%; font-size: 20px;color: black; text-transform: uppercase;">Sản phẩm
                liên quan</h1>
            <div style="width: 100%;">
                <div class="features_items">
                <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach($relatedProducts->chunk(6) as $products)
            <div class="item {{ $loop->first ? 'active' : '' }}">
                @foreach($products as $product)
                    <div class="col-sm-2" style="padding: 12px;">
                        <div class="product-item" style="margin: 0 -5px;">
                            <a style="text-decoration: none;" href="{{ route('product.detail', ['slug' => $product->product_slug, 'pid' => $product->id]) }}">
                                <div class="product-top">
                                    @if($product->product_discount > 0)
                                        <span class="product-discount">{{ $product->product_discount }}%</span>
                                    @endif
                                    <img src="{{ $product->product_thumb }}" alt="{{ $product->product_name }}" />
                                </div>
                                <div class="product-content">
                                    <div class="product-title long-text">{{ $product->product_name }}</div>
                                    <div class="product-price">
                                        @if($product->product_discount == 0)
                                            ₫{{ number_format($product->product_price, 0, ',', '.') }}
                                        @else
                                            <div class="product-price-old">₫{{ number_format($product->product_price, 0, ',', '.') }}</div>
                                            <div class="product-price-new">
                                                ₫{{ number_format($product->product_price - ($product->product_price * $product->product_discount / 100), 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <div class="product-rating">
                                            @php $rating = $product->product_ratings; @endphp
                                            @foreach(range(1, 5) as $i)
                                                <span class="fa-stack" style="width: 1em;">
                                                    <i class="far fa-star fa-stack-1x"></i>
                                                    @if($rating > 0)
                                                        @if($rating > 0.5)
                                                            <i class="fas fa-star fa-stack-1x"></i>
                                                        @else
                                                            <i class="fas fa-star-half fa-stack-1x"></i>
                                                        @endif
                                                    @endif
                                                    @php $rating--; @endphp
                                                </span>
                                            @endforeach
                                        </div>
                                        <div class="product-sold">Đã bán {{ $product->product_sold }}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    @if(count($relatedProducts) > 6)
        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    @endif
                </div>
            </div>
        </div>
    </div>
    @endif



   
</div>
