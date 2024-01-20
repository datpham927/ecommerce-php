<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormBrandRequest extends FormRequest
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
            "brand_name" => 'required',
            "brand_description" => 'required|min:10' 
        ];
    }
    public function messages(){
        return [
                "brand_name.required" => 'Không được để trống!',
                "brand_description.required" => 'Không được để trống!',
                "brand_description.min" => 'Không được ít hơn 10 kí tự!'
        ];
    }
}