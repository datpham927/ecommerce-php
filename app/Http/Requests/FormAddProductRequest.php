<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormAddProductRequest extends FormRequest
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
            "product_name" => 'bail|required|min:20',
            "product_price" => 'required', 
            "product_discount" => 'required', 
            "product_description" => 'required|min:20' ,
            "product_sizes" => 'required|array',
            "product_category_id" => 'required|gt:-1' ,
            "product_brand_id" => 'required|gt:-1' ,
            "product_images" => 'required|array|min:3' ,
            "product_thumb" => 'required' ,
        ];
    }
    public function messages(){
        return [
                "product_name.required" => 'Vui lòng nhập tên sản phẩm!',
                "product_price.required" => 'Vui lòng nhập giá sản phẩm!',
                "product_description.required" => 'Vui lòng nhập mô tả sản phẩm!',
                "product_quantities.required" => 'Vui lòng nhập số lượng sản phẩm!',
                "product_sizes.required" => 'Vui lòng nhập tên size (vd: L, M, XL...)!',
                "product_thumb.required" => 'Vui lòng chọn hình ảnh!',
                "product_images.required" => 'Vui lòng chọn hình ảnh!',
                "product_images.min" => 'Vui lòng chọn tối thiểu 3 hình ảnh!',
                "product_category_id.gt" => 'Vui lòng chọn danh mục!' ,
                "product_brand_id.gt" => 'Vui lòng chọn thương hiệu!' ,
                "product_attribute_keys.required" => 'Vui lòng nhập tên thuộc tính (vd: màu sắc...)!',
                "product_attribute_names.required" => 'Vui lòng nhập mô tả thuộc tính (vd: màu hồng...)!',
                "product_name.min" => 'Tên sản phẩm tối thiểu 20 kí tự!',
                "product_description.min" => 'Mô tả sản phẩm tối thiểu 20 kí tự!',
            ];
    }
}
