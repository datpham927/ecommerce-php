<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormSliderRequest extends FormRequest
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
            "slider_name" => 'required',
            "slider_image" => 'required',
            "slider_description" => 'required|min:10' 
        ];
    }
    public function messages(){
        return [
                "slider_name.required" => 'Không được để trống!',
                "slider_image.required" => 'Không được để trống!',
                "slider_description.required" => 'Không được để trống!',
                "slider_description.min" => 'Không được ít hơn 10 kí tự!'
        ];
    }
}