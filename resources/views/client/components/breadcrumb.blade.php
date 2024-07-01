<nav aria-label="breadcrumb" class="m-0">
  <ul class="breadcrumb m-0"  >
  <li class="breadcrumb-item"><a  class="text-[#05a]"  href="/">Trang chủ</a></li>
    @foreach ($breadcrumb as $item )
    @if($item["link"])
    <li class="breadcrumb-item"><a class="text-[#05a]" href="{{$item["link"]}}">{{$item["label"]}}</a></li>
   @else
   <li class="breadcrumb-item" >{{$item["label"]}}</li>
   @endif
    @endforeach
  </ul>
</nav> 