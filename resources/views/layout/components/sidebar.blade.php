<div class="left-sidebar">
                            <h2>Danh mục</h2>
                            <div class="panel-group category-products" id="accordian">
                                <!--category-productsr-->

                                @foreach($categories as $category)
                                @if($category->parent_id == 0)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordian"
                                                href="#{{$category->slug}}">
                                                <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                                {{$category->name}}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="{{$category->slug}}" class="panel-collapse collapse">
                                        <div class="panel-body"
                                            style="padding: 10px 15px;background-color: rgb(245, 245, 245);">
                                            <ul>
                                                @foreach($categories as $child)
                                                @if($child->parent_id == $category->id)
                                                <li><a
                                                        href="{{ route('category.show_home', ['cid' => $child->id, 'slug' => $child->slug]) }}">{{$child->name}}</a>
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
                            <!--/category-products-->

                            <div class="brands_products">
                                <!--brands_products-->
                                <h2>Thương hiệu</h2>
                                <div class="brands-name">
                                    <ul class="nav nav-pills nav-stacked">
                                        @foreach($brands as $brand)
                                        <li>
                                            <a href="{{route('brand.show_home', ['bid' => $brand->brand_id, 'slug' => $brand->slug]) }}"> {{$brand->name}}</a>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <!--/brands_products-->


                            <!--/price-range-->


                            <!--/shipping-->

                        </div>