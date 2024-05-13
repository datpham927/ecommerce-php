@extends("layout.admin")

@section("content")
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách tài khoản khách hàng
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-3">
                <button class="btn btn-sm btn-info">
                    <a href="{{route('customer.add')}}" style="color:white">
                        Tạo tài khoản
                    </a>
                </button>
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
                            <a href="{{route('customer.edit',['id'=>$customer->id])}}" style="width: 100px;"
                                class="btn btn-default">Edit</a>
                            @if($customer->user_is_block)
                                <a data-url="{{route('customer.is_active',['id'=>$customer->id])}}" style="width: 100px;"
                                    class="btn btn-default  btn-customer-is_active">Active</a>
                            @else
                                <a data-url="{{route('customer.is_block',['id'=>$customer->id])}}" style="width: 100px;"
                                    class="btn btn-default  btn-customer-is_block">Block</a>
                            @endif
                            <a href='' data-url="{{route('customer.delete',['id'=>$customer->id])}}"
                                class="btn btn-danger btn-delete-customer" style="width: 100px;">Remove</a>

                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="col-md-12 custom-pagination">
                {{ $customers ->links('pagination::bootstrap-4') }}
            </div>
        </footer>
    </div>
</div>

@endsection