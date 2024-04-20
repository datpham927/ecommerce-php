@extends("layout.admin")


@section("title")
<title>Thêm vai trò</title>
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
            Thêm vai trò
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('role.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="role_name">Tên vai trò</label>
                        <input type="text" class="form-control @error('role_name') is-invalid @enderror"
                            id="role_name" name="role_name" placeholder="Nhập tên vai trò" />
                        @error('role_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role_display_name">Tên hiển thị</label>
                        <input type="text" class="form-control @error('role_display_name') is-invalid @enderror"
                            id="role_display_name" name="role_display_name" placeholder="Nhập tên hiển thị " />
                        @error('role_display_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>

            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection