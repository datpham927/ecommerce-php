<div class="left-sidebar">

    @if(isset($categories))
    <h2>Danh mục</h2>
    <div class="panel-group category-products" id="accordian">
        <!--category-productsr-->

        @foreach($categories as $category)
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <a
                        href="{{ route('category.show_product_home', ['cid' => $category->id, 'slug' => $category->category_slug]) }}">{{$category->category_name}}</a>
                </div>
            </div>

        </div>
        @endforeach

    </div>
    @endif
    <!--/category-products-->
    @if(isset($brands))
    <div class="brands_products">
        <!--brands_products-->
        <h2>Thương hiệu</h2>
        <div class="brands-name">
            <ul class="nav nav-pills nav-stacked">
                @foreach($brands as $brand)
                <li>
                    <a
                        href="{{route('brand.show_product_home', ['bid' => $brand->id, 'slug' => $brand->brand_slug]) }}">
                        {{$brand->brand_name}}</a>
                </li>
                @endforeach

            </ul>
        </div>
    </div>
    @endif
</div>