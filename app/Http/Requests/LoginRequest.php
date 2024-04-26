<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'user_email' => 'required',
            'user_password' => 'required', 
        ];
    }
    public function messages(){
        return [
            "user_email.required"=> "Gmail không được trống", 
            "user_password.required"=> "Mật khẩu không được trống",  
        ];
    }
}
