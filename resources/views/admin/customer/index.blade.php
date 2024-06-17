@extends("admin.layout.index")

@section("content")
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách tài khoản khách hàng
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-7 m-b-xs">
                <form action="{{ url()->current() }}" method="GET" class="col-sm-12 m-b-xs" style="display: flex;">
                    <div class="col-sm-6" style="display: flex; justify-items: center; text-align: center;">
                        <input type="text" name='name' value="{{ $userName ?? '' }}" class="input-sm form-control"
                            style="margin-right: 20px;" placeholder="Nhập tên cần tìm kiếm">
                    </div>
                    <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                </form>
            </div>
            <div class="col-sm-2">
            </div>
            <div class="col-sm-3">
            @can(config("permission.access.add-customer"))
                <button class="btn btn-sm btn-info">
                    <a href="{{route('customer.add')}}" style="color:white">
                        Tạo tài khoản
                    </a>
                </button>
                @endcan
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th style="text-align: center;">ID</th>
                        <th style="text-align: center;">Hình ảnh</th>
                        <th style="text-align: center;">Tên người dùng</th>
                        <th style="text-align: center;">Trạng thái</th>
                        <th style="text-align: center;">Đơn hàng đã mua</th>
                        <th style="text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td style="text-align: center;">{{$customer->id}}</td>
                        <td style="text-align: center;">
                            <img style="width: 40px; border-radius: 4px;" src="{{$customer->user_image_url}}" />
                        </td>
                        <td style="text-align: center;"><span class="text-ellipsis">{{$customer->user_name}}</span></td>
                        <td style="text-align: center;"><span
                                class="text-ellipsis">{{$customer->user_is_block==true?"Đã bị chặn":"Đang hoạt động"}}</span>
                        </td>
                        <td style="text-align: center;"><span class="text-ellipsis">{{count($customer->Orders)}}</span>
                        </td>
                        <td
                            style="display: flex; flex-direction: column;justify-content: center;align-items: center;gap: 4px;">
                            @can(config("permission.access.add-customer"))
                            <a href="{{route('customer.edit',['id'=>$customer->id])}}" style="width: 100px;"
                                class="btn btn-default">Edit</a>

                            @if($customer->user_is_block)
                            <a data-url="{{route('customer.is_active',['id'=>$customer->id])}}" style="width: 100px;"
                                class="btn btn-default  btn-customer-is_active">Active</a>
                            @else
                            <a data-url="{{route('customer.is_block',['id'=>$customer->id])}}" style="width: 100px;"
                                class="btn btn-default  btn-customer-is_block">Block</a>
                            @endif
                            @endcan
                            @can(config("permission.access.delete-customer"))
                            <a href='' data-url="{{route('customer.delete',['id'=>$customer->id])}}"
                                class="btn btn-danger btn-delete-customer" style="width: 100px;">Remove</a>
                                @endcan
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            @include('components.pagination',['list'=>$customers,'title'=>'Không có khách hàng nào!'])
        </footer>
    </div>
</div>

@endsection