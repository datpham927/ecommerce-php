@extends("admin.layout.index")


@section("title")
<title>Phí vận chuyển</title>
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
        <div class="panel-heading" style="background:none ;">
            Phí vận chuyển
        </div>
        <div class="row" style="display: flex;justify-content: center;">
            <div class="col-md-6">
                <form action="{{route('delivery.add')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="city">Chọn thành phố</label>
                        <select class="form-control choose city"  name="city" required>
                            <option value=''>Chọn thành phố</option>
                            @foreach($cities as $city)
                            <option value='{{$city->matp}}'>{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="province">Quận huyện</label>
                        <select class="form-control choose province" name="province" required>
                            <option value=''>Chọn quận huyện</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ward">Chọn xã phường</label>
                        <select class="form-control ward"  name="ward" required>
                            <option value="">Chọn xã phường</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="feeship">Phí ship</label>
                        <input type="number" class="form-control  @error('feeship') is-invalid @enderror" id="feeship"
                            name="feeship" placeholder="Nhập phí ship" />
                        @error('feeship')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div style="width: 100%;display: flex; justify-content: center;">
                        <button type="submit" class="btn btn-primary" style="width: 100px;">Thêm</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th style="text-align: center;"> ID</th>
                        <th style="text-align: center;">Tỉnh thành phố</th>
                        <th style="text-align: center;">Quận huyện</th>
                        <th style="text-align: center;">Xã phường</th>
                        <th style="text-align: center;">Phí vận chuyển</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feeships as $feeship)
                    @php
                    @endphp
                    <tr>
                        <td>{{$feeship->id}}</td>
                        <td><span class="text-ellipsis" style="text-align: center;">{{$feeship->City->name}}</span></td>
                        <td><span class="text-ellipsis" style="text-align: center;">{{$feeship->Province->name}}</span>
                        </td>
                        <td><span class="text-ellipsis" style="text-align: center;">{{$feeship->Ward->name??""}}</span></td>
                        <td><input class="form-control freeship"
                        type="number"
                                data-url="{{route('delivery.update',['id'=>$feeship->id])}}"
                                style="width: 200px; margin:auto;text-align: center;" value="{{$feeship->feeship}}" />
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            @include('components.pagination',['list'=>$feeships,'title'=>'Không có danh mục nào!'])
        </footer>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection