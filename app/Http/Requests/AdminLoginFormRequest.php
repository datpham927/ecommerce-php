<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'admin_name' => 'required|unique:admins',
            'admin_address' => 'required',
            'admin_mobile' => 'required|numeric',
            'admin_cmnd' => 'required',
            'admin_password' => 'required|min:6',
            'password_confirm' => 'required|same:admin_password',
            'admin_image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'admin_roles' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'admin_name.required' => 'Vui lòng nhập tên đăng nhập.',
            'admin_name.unique' => 'Tên đăng nhập đã tồn tại trong hệ thống.',
            'admin_address.required' => 'Vui lòng nhập địa chỉ.',
            'admin_cmnd.required' => 'Vui lòng nhập chứng minh nhân dân.',
            'admin_roles.required' => 'Vui lòng chọn vai trò.',
            'admin_mobile.required' => 'Vui lòng nhập số điện thoại.',
            'admin_mobile.numeric' => 'Số điện thoại phải là số.',
            'admin_password.required' => 'Vui lòng nhập mật khẩu.',
            'admin_password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password_confirm.required' => 'Vui lòng xác nhận mật khẩu.',
            'password_confirm.same' => 'Mật khẩu xác nhận không khớp.',
            'admin_image_url.required' => 'Vui lòng chọn ảnh đại diện.',
            'admin_image_url.image' => 'Tệp được chọn không phải là hình ảnh.',
            'admin_image_url.mimes' => 'Định dạng hình ảnh không hợp lệ.',
            'admin_image_url.max' => 'Kích thước ảnh không được lớn hơn :max KB.',
        ];
    }
}
