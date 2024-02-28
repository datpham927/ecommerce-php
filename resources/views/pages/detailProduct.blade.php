@extends("layout.client")
@section("css")
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

@endsection
@section("js")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
$('.arrUpdate').click(function(e) {
    val = ''; // for holding the temporary values

    $('.arrActiviteit label').each(function(key, value) {
        if (value.className.indexOf('active') >= 0) {
            val += value.dataset.wat
        }
    })

    // just for debug reasons.
    $('#hierHier').html(val);

})
$(document).ready(function() {
    var quantitiy = 0;
    $('.quantity-right-plus').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        // If is not undefined
        $('#quantity').val(quantity + 1);
        // Increment
    });
    $('.quantity-left-minus').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        // If is not undefined
        // Increment
        if (quantity > 0) {
            $('#quantity').val(quantity - 1);
        }
    });
});
$(document).ready(function() {
    const buttons = document.querySelectorAll('.btn-group .btn-size');
    // Add an event listener to each button
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove the "active" class from all buttons
            buttons.forEach(btn => {
                btn.classList.remove('active');
            });
            // Add the "active" class to the clicked button
            button.classList.add('active');
        });
    });
});
</script>
@endsection

@section("body")
<div class="container">
    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12 padding-right" style="background-color: white; padding: 5px 0;">
            <div class="product-details">
                <!--product-details-->
                <div class="col-sm-5">
                    <div class="view-product">
                        <img src="{{$detailProduct->thumb}}" alt="" />
                    </div>
                    <div id="similar-product" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($detailProduct->Image->chunk(4) as $images)
                            <div class="item {{ $loop->first ? 'active' : '' }}">
                                @foreach($images as $image)
                                <div class="col-sm-3 small-image" style="padding: 0 5px;">
                                    <img style="width: 100%; object-fit: contain;" src="{{$image->url}}" alt="">
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>

                        @if(count($detailProduct->Image) > 4)
                        <!-- Controls -->
                        <a class="left item-control" href="#similar-product" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right item-control" href="#similar-product" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                        @endif

                    </div>

                </div>
                <div class="col-sm-7">
                    <div class="product-information">
                        <!--/product-information-->
                        <div style="display: flex;font-size: 12px;">
                            Thương hiệu: <span
                                style="color: #ee4d2d; cursor: pointer;margin-left: 2px;">{{$detailProduct->brand->name}}</span>
                        </div>
                        <h2 style="margin: 10px 0;font-size: 25px;">{{$detailProduct->name}}</h2>
                        <div style="display: flex;align-items: center;">
                            <div class="product-rating" style="display: flex;">
                                @php $rating = $detailProduct->ratings; @endphp
                                @foreach(range(1,5) as $i)
                                <span class="fa-stack" style="width:1em;margin:0;margin-right: 3px">
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
                            <div
                                style="font-size: 16px;  margin-left: 10px;padding-left: 10px;border-left: 1px solid rgba(0,0,0,.14);">
                                {{$detailProduct->sold}}
                                <span class="title" style="font-size: 12px">Đã bán</span>
                            </div>
                        </div>
                        <div class="product-price">
                            @if($detailProduct->discount == 0)
                            ₫{{ number_format($detailProduct->price , 0, ',', '.') }}
                            @else
                            <div class="product-price-old" style="font-size: 15px;">
                                ₫{{number_format($detailProduct->price , 0, ',', '.') }}</div>
                            <div class="product-price-new" style="font-size: 25px;">
                                ₫{{number_format( $detailProduct->price - ($detailProduct->price * $detailProduct->discount / 100) , 0, ',', '.')}}
                            </div>
                            @endif
                        </div>
                        <div class="container-option-size">
                            <h3 class="title">Kích thước</h3>
                            <div class="btn-group">
                                @foreach($detailProduct->Size as $size)
                                <button type="button" class=" btn-size  " name="size">{{$size->name}}
                                    <div class="NkXHv4"><img alt="icon-tick-bold" class="QX2JQy"
                                            src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/productdetailspage/9057d6e718e722cde0e8.svg">
                                    </div>
                                </button>
                                @endforeach
                            </div>
                        </div>
                        <div style="width: 100%;display: flex;align-items: center;margin: 30px 0;">
                            <h3 class="title">Số lượng</h3>
                            <div class="input-button-group">
                                <button type="button" class="quantity-left-minus" data-type="minus" data-field="">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                                <input type="text" id="quantity" name="quantity" class="input-number" value="0" min="0"
                                    max="100">
                                <button type="button" class="quantity-right-plus" data-type="plus" data-field="">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </div>
                            <span style=" color: #757575;margin-left: 30px;">{{$detailProduct->stock}} sản phẩm
                                có sẵn</span>
                        </div>
                        <button type="button" class="btn-add-cart" style="border-radius: 2px; outline: none;">
                            <i class="fa fa-shopping-cart"></i>
                            Thêm vào giỏ hàng
                        </button>

                    </div>
                    <!--/product-information-->
                </div>
            </div>

        </div>
    </div>
</div>
<div class="container" style="background-color: white; margin-top: 20px;padding: 20px;">
    <h1 class="title" style="width: 100%; font-size: 20px;">Sản phẩm liên quan</h1>
    <div class="col-sm-12">
        <div class="features_items">
            <div id="similar-product" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($relatedProducts->chunk(6) as $products)
                    <div class="item {{ $loop->first ? 'active' : '' }}">
                        @foreach($products as $product)
                        
                        <div class="col-sm-2" style="padding: 12px;">
                            <div class="product-item" style="margin: 0 -5px ;">
                                <a
                                style="text-decoration: none;"
                                    href="{{route('product.detail',['slug'=>$product->slug,'pid'=>$product->id])}}">
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
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>

                @if(count($relatedProducts) > 4)
                <!-- Controls -->
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
@endsection