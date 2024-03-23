<div class="left-sidebar">

    @if(isset($categories))
    <h2>Danh mục</h2>
    <div class="panel-group category-products" id="accordian">
        <!--category-productsr-->

        @foreach($categories as $category)
        @if($category->category_parent_id == 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordian" href="#{{$category->category_slug}}">
                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                        {{$category->category_name}}
                    </a>
                </h4>
            </div>
            <div id="{{$category->category_slug}}" class="panel-collapse collapse">
                <div class="panel-body" style="padding: 10px 15px">
                    <ul>
                        @foreach($categories as $category_child)
                        @if($category_child->category_parent_id == $category->id)
                        <li><a
                                href="{{ route('category.show_product_home', ['cid' => $category_child->id, 'slug' => $category_child->category_slug]) }}">{{$category_child->category_name}}</a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
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