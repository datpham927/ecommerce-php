@extends("client.pages.user.index")

@section("content")

<div class="flex flex-col motion-safe:w-full w-[80%]">
    <div
        class="tablet:fixed tablet:top-0 tablet:right-0 tablet:z-[1000] w-full h-full bg-white overflow-hidden p-4 laptop:rounded-lg  tablet:overflow-y-scroll ">
        <a class="text-secondary laptop:hidden " href="/user/account"><svg
                class="MuiSvgIcon-root MuiSvgIcon-fontSizeLarge css-6flbmm" focusable="false" aria-hidden="true"
                viewBox="0 0 24 24" data-testid="ChevronLeftIcon">
                <path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"></path>
            </svg></a>
        <div class="w-full mb-4 ">
            <h1 class="text-left text-2xl">Hồ Sơ Của Tôi</h1><span class="  text-secondary ">Quản lý thông tin hồ sơ để
                bảo
                mật tài khoản</span>
        </div>


        <div class="col-md-12 border-right">
            <form action="{{route('user.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="w-full flex">
                    <div
                        class="flex tablet:flex-col tablet:gap-4 py-10 border-solid border-t-[1px] border-slate-200 w-full">
                        <div style="background-color: white; padding: 20px;" class=" w-1/2 ">
                            <div class="row mt-2" style="margin-top: 20px;">
                                <label class="labels">Tên</label>
                                <input type="text" required class="form-control" placeholder="Nhập tên" name="user_name"
                                    value="{{$user->user_name}}">

                            </div>
                            <div class="row mt-2" style="margin-top: 20px;">

                                <label class="Số điện thoại">Số điện thoại</label>
                                <input type="number" class="form-control" name="user_mobile"
                                    placeholder="Nhập số điện thoại" value="{{$user->user_mobile}}">

                            </div>
                            <div class="row mt-3" style="margin-top: 20px;">
                                <label class="labels">Email</label>
                                <button type="button"
                                    style="outline: none; text-align: start; background-color:#E9E9ED ; cursor: auto;border: none;"
                                    class="form-control" name="user_email">
                                    {{$user->user_email}}
                                </button>
                            </div>

                            <div class="row mt-3" style="margin-top: 20px;"> <label for="city">Chọn thành phố</label>
                                <select class="form-control choose city" name="city" required>
                                    <option value=''>Chọn thành phố</option>
                                    @foreach($cities as $city)
                                    <option value='{{$city->matp}}'
                                        {{ $user->user_city_id === $city->matp ? 'selected' : '' }}>{{$city->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mt-3" style="margin-top: 20px;"><label for="province">Quận huyện</label>
                                <select class="form-control choose province" name="province" required>
                                    @foreach($provinces as $province)
                                    <option value='{{$province->maqh}}'
                                        {{ $user->user_province_id === $province->maqh ? 'selected' : '' }}>
                                        {{$province->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mt-3" style="margin-top: 20px;"> <label for="ward">Chọn xã phường</label>
                                <select class="form-control ward" name="ward" required>
                                    @foreach($wards as $ward)
                                    <option value='{{$ward->xaid}}'
                                        {{ $user->user_ward_id === $ward->xaid ? 'selected' : '' }}>{{$ward->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col  w-1/2 items-center gap-4 justify-center">
                            <div class="add-avatar flex flex-col w-full items-center gap-4 ">
                                <div
                                    class="w-[200px] h-[200px] rounded-full overflow-hidden mx-auto  border-[1px] border-solid border-separate">
                                    <img class="w-full h-full object-cover block"
                                        src="{{$user->user_image_url??"https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"}}">
                                </div>
                                <label for="user_image_url">
                                Chọn ảnh
                                    <input type="file" class="user-avatar @error('user_image_url') is-invalid @enderror"
                                        value='{{$user->user_image_url??"https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"}}' data-url='{{route("upload_image")}}'
                                        id="user_image_url" style="display: none;" name="user_image_url" />
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-center" style="margin-top: 30px;  ">
                    <button class="btn btn-primary profile-button" type="submit"
                        style="padding: 10px 40px; border-radius: 2px">
                        Cập nhật
                    </button>
                </div>
            </form>



        </div>


    </div>
</div> 

@endsection