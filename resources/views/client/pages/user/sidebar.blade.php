<div class="flex flex-col w-full gap-6 bg-white py-3 rounded-md overflow-hidden">
    <div class="flex gap-2 items-center ml-2">
        <div class="w-11 h-11 overflow-hidden rounded-full border-[1px] border-solid border-separate"><img
                src="{{$user->user_image_url}}" class="w-full h-full object-cover block"></div>
        <div class="flex flex-col  text-secondary">Tài khoản của<span
                class=" font-normal text-black ">{{$user->user_name}}</span></div>
    </div>
    <ul class="w-full h-full">
        <li>
            <a aria-current="page"
                class="flex gap-4 p-2 text-secondary hover:bg-gray-200 cursor-pointer "
                href="{{ route('user.profile') }}">
                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false" aria-hidden="true"
                    viewBox="0 0 24 24" data-testid="PersonIcon" style="color: rgb(155, 155, 155);">
                    <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z">
                    </path>
                </svg>
                Thông tin tài khoản
            </a>
        </li>
        <li>
            <a class="flex gap-4 p-2 text-secondary hover:bg-gray-200 cursor-pointer"
                href="{{route("order.order_list")}}">
                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false" aria-hidden="true"
                    viewBox="0 0 24 24" data-testid="ShoppingBasketIcon" style="color: rgb(155, 155, 155);">
                    <path
                        d="m17.21 9-4.38-6.56c-.19-.28-.51-.42-.83-.42-.32 0-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1h-4.79zM9 9l3-4.4L15 9H9zm3 8c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z">
                    </path>
                </svg>
                Đơn mua
            </a>
        </li>
        <li>
            <a href="{{route('user.logout')}}" class="flex gap-4 p-2 text-secondary hover:bg-gray-200 cursor-pointer"
                href="/user/account/product">
                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-dhaba5" focusable="false" aria-hidden="true"
                    viewBox="0 0 24 24" data-testid="LogoutIcon">
                    <path
                        d="m17 7-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4z">
                    </path>
                </svg>
                Đăng xuất
            </a>


        </li>
    </ul>

</div>