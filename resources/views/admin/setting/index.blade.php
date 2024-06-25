@extends("admin.layout.index")

@section("title")
<title>Cài đặt thông tin</title>
@endsection

@section("content")
<div class="content">
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
        @php
        Session::forget('success');
        @endphp
    </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <form action="{{ route('admin.setting.store') }}" style="width: 100%" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @foreach ($config as $item)
                <div class="col-md-12" style="margin: 20px 0;">
                    <div class='row'>
                        <div class="col-md-5" style="margin: 20px 0;">
                            <h2 style="font-size:20px; margin: 10px 0;">{{ $item["label"] }}</h2>
                            <span style="font-size:12px;">{{ $item["description"] }}</span>
                        </div>
                        <div class="col-md-7"
                            style="background-color: rgb(245, 245, 245); padding:10px; border-radius: 8px;">
                            @php
                            $value = $item['value'];
                            @endphp
                            @foreach ($value as $valueItem)
                            @php
                            $name = $valueItem['key'];
                            $label = $valueItem['label'];
                            $val = $setting[$valueItem["key"]]??"";
                            @endphp
                            @switch($valueItem["type"])
                            @case('text')
                            {!! renderSettingInputText($name, $label, $val) !!}
                            @break
                            @case('image')
                            {!! renderSettingInputImage($name, $label,$val) !!}
                            @break
                            @endswitch
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
                @can(config("permission.access.list-setting"))
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
                @endcan
            </form>
        </div>
    </div>
</div>
@endsection