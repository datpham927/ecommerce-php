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
                        <th style="text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td style="text-align: center;" >{{$customer->id}}</td>
                        <td style="text-align: center;">
                            <img style="width: 40px; border-radius: 4px;" src="{{$customer->user_image_url}}" />
                        </td>
                        <td style="text-align: center;"><span class="text-ellipsis">{{$customer->user_name}}</span></td>
                         
                        <td style="display: flex; justify-content: center; gap: 30px;">
                            <a href="{{route('customer.edit',['id'=>$customer->id])}}" class="btn btn-default">Edit</a>
                            <a href='' data-url="{{route('customer.delete',['id'=>$customer->id])}}"
                                class="btn btn-danger btn-delete-customer">Remove</a>
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