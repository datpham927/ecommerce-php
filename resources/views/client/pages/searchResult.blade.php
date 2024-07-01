@extends("client.layout.index")


@section("footer")
@include("client.layout.components.footer")
@endsection


@section("body")
<section>
    <div class="container">
    @include("client.components.breadcrumb")

        <div class="row">
            <h2 style="font-weight: 400; margin-left: 20px; font-size: 20px;">Kết quả tìm kiếm "{{$query}}"</h2>
            @if(count($products)>0)
            <div class="features_items">
                @foreach($products as $product)
                @include('client.components.productItem',['col'=>'col-sm-2'])
                @endforeach
            </div>
            @endif
            @include('components.pagination',['list'=>$products,'title'=>'Không có sản phẩm nào!'])
        </div>

    </div>
    </div>
</section>



@endsection