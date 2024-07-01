<section id="slider">
    <!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ul class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ul>
                    <div class="carousel-inner" style="width: 100%;">
                        @foreach($sliders as $key => $slider)
                        <a class="item {{ $key == 0 ? 'active' : '' }}"
                            href=" {{route('category.show_product_home', ['cid' =>$slider->category->id, 'slug' => $slider->category->category_slug]) }}">
                            <img src='{{ $slider->slider_image }}' style="display: block; width: 100%;" />
                        </a>
                        @endforeach

                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>