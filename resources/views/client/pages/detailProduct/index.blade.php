@extends("client.layout.index")

@section("footer")
@include("client.layout.components.footer")
@endsection

@section("css")
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
@endsection

@section("js")
<script src="{{ asset('frontend/js/comment.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('.arrUpdate').click(function(e) {
        let val = '';
        $('.arrActiviteit label').each(function(key, value) {
            if (value.className.indexOf('active') >= 0) {
                val += value.dataset.wat;
            }
        });
        $('#hierHier').html(val);
    });

    let quantity = 0;
    $('.quantity-right-plus').click(function(e) {
        e.preventDefault();
        quantity = parseInt($('#quantity').val());
        let maxProduct = $('#quantity').attr('max');
        if (quantity < maxProduct) {
            $('#quantity').val(quantity + 1);
        }
    });

    $('.quantity-left-minus').click(function(e) {
        e.preventDefault();
        quantity = parseInt($('#quantity').val());
        if (quantity > 0) {
            $('#quantity').val(quantity - 1);
        }
    });

    const buttons = document.querySelectorAll('.btn-group .btn-size');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            buttons.forEach(btn => {
                btn.classList.remove('active');
            });
            button.classList.add('active');
        });
    });
});
</script>
@endsection

@section("body")
<div class="container">
    <div class="row" >
    @include("client.components.breadcrumb")
    @include('client.pages.detailProduct.top') 
    @include('client.pages.detailProduct.relatedProduct')
    @include('client.pages.detailProduct.productAttribute')
    @include('client.pages.detailProduct.productDescription')
    @include('client.pages.detailProduct.productComment')
</div>
</div>
@endsection