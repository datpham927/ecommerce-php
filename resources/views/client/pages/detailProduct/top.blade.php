<div class='container' style="background-color: white;padding: 20px;">
    <div class="col-sm-12" style="background-color: white;">
        <div class="product-details">
            <div class="col-sm-5">
                <div class="view-product">
                    <img src="{{ $detailProduct->product_thumb }}" alt="" />
                </div>
            </div>
            <div class="col-sm-7">
                <div class="product-information">
                    <div style="display: flex;font-size: 12px;">
                        Thương hiệu: <a
                            href="{{ route('brand.show_product_home', ['bid' => $detailProduct->brand->id, 'slug' => $detailProduct->brand->brand_slug]) }}"
                            style="color: #ee4d2d; cursor: pointer;margin-left: 2px;">{{ $detailProduct->brand->brand_name }}</a>
                    </div>
                    <h2 style="margin: 10px 0;font-size: 25px;">{{ $detailProduct->product_name }}</h2>
                    <div style="display: flex;align-items: center;">
                        @php $rating = $detailProduct->product_ratings; @endphp
                        @include("utils.formatRating",['rating'=>$rating])
                        <div
                            style="font-size: 16px; margin-left: 10px;padding-left: 10px;border-left: 1px solid rgba(0,0,0,.14);">
                            {{ $detailProduct->product_sold }} <span class="title" style="font-size: 12px">Đã
                                bán</span>
                        </div>
                    </div>
                    <div class="product-price">
                        @if($detailProduct->product_discount == 0)
                        {{ number_format($detailProduct->product_price, 0, ',', '.') }}₫
                        @else
                        <div class="product-price-old" style="font-size: 15px;">
                            {{ number_format($detailProduct->product_price, 0, ',', '.') }}₫
                        </div>
                        <div class="product-price-new" style="font-size: 25px;">
                            ₫{{ number_format($detailProduct->product_price - ($detailProduct->product_price * $detailProduct->product_discount / 100), 0, ',', '.') }}₫
                        </div>
                        @endif
                    </div>
                    <form action="{{ route('cart.add_cart') }}" method="post">
                        @csrf
                        <input name="productId_hidden" type="hidden" value="{{ $detailProduct->id }}" />
                        <input name="price_hidden" type="hidden"
                            value="{{ $detailProduct->product_price - ($detailProduct->product_price * $detailProduct->product_discount / 100) }}" />
                        <div class="container-option-size">
                            <h3 class="title" style="width: 100px;">Kích thước</h3>
                            <div class="btn-group" style="display: flex;">
                                @foreach($detailProduct->Size as $size)
                                <button type="button" class="btn-size" title="{{ $size->size_product_quantity }}"
                                    name="product_size">{{ $size->size_name }}
                                    <div class="NkXHv4"><img alt="icon-tick-bold" class="QX2JQy"
                                            src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/productdetailspage/9057d6e718e722cde0e8.svg">
                                    </div>
                                </button>
                                @endforeach
                            </div>
                        </div>
                        <div style="width: 100%;display: flex;align-items: center;margin: 30px 0;">
                            <h3 class="title" style="width: 100px;">Số lượng</h3>
                            <div class="input-button-group">
                                <button type="button" class="quantity-left-minus" data-type="minus" data-field="">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                                <input type="text" id="quantity" name="quantity" class="input-number" value="1" min="1"
                                    max="{{ $detailProduct->product_stock }}">
                                <button type="button" class="quantity-right-plus" data-type="plus" data-field="">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </div>
                            <div style="display: flex; color: #757575;margin-left: 30px;" class="quantity-product">
                                <span style='padding-right: 5px;'>{{ $detailProduct->product_stock }} </span>sản
                                phẩm có sẵn
                            </div>
                        </div>

                        @if(!Auth::check() || ( Auth::check()&& Auth::user()->user_type === 'customer'))
                        <button type="submit" class="btn-add-cart" style="border-radius: 2px; outline: none;">
                            <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                        </button>
                        @endif

                    </form>
                </div>

                <div id="similar-product" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($detailProduct->Image->chunk(4) as $images)
                        <div class="item {{ $loop->first ? 'active' : '' }}">
                            @foreach($images as $image)
                            <div class="col-sm-3 small-image" style="padding: 0 5px;">
                                <img style="width: 100%; object-fit: contain;" src="{{ $image->image_url }}" alt="">
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    @if(count($detailProduct->Image) > 4)
                    <a class="left item-control" href="#similar-product" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="right item-control" href="#similar-product" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>