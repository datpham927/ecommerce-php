@extends("layout.client.index")

@section("slider")
@include("layout.client.components.slider")
@endsection

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
                <div class="features_items">
                    <!--features_items-->
                    <!-- <h2 class="title text-center">Features Items</h2> -->
                    @foreach($products as $product)
                    @include('components.productItem',['comment'=>$product])
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
                                @include('components.productItem',['comment'=>$product])
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

                <div class="recommended_items" style="margin: 30px 0">
                    <!--recommended_items-->
                    <div style="width: 100%; padding: 0 10px;">
                        <h2 class="title" style="margin: 0;">Sản phẩm bán chạy</h2>
                    </div>
                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($HotSellingProducts as $itemProducts)
                                @include('components.productItem',['product'=>$itemProducts])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



@endsection