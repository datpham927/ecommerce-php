@if($list->count()==0)
<div style=" display: flex;height: 400px;  align-items: center;justify-content: center; background-color: white;">
    <div style="display: flex;flex-direction: column;align-items: center;">
        <img style='width: 100px;'
            src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f4.png" />
        <span style="margin: 10px 0;">{{$title}}</span>
    </div>
</div>
@endif
@if($list->count()>0)
<div class="col-md-12 custom-pagination">
    {{ $list->links('pagination::bootstrap-4') }}
</div>
@endif