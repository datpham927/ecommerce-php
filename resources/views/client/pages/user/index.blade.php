@extends("client.layout.index")

@section('js')
<script src="{{asset('frontend/js/address.js')}}"></script>
@endsection

@section("body")
<div class="container " style="padding-top: 20px;">
<div class="flex mt-5 w-full h-full gap-4">
            <div class="tablet:hidden flex w-[20%] shrink-0">
                @include("client.pages.user.sidebar")
            </div>
            <div class="flex flex-col motion-safe:w-full w-[80%]">
               @yield('content')
            </div>
        </div>
</div>

@endsection