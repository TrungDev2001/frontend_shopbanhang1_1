<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Captcha;

class LoginValidator extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'emailLogin' => 'required',
            'passwordLogin' => 'required',
            //'g-recaptcha-response' => new Captcha(),         //dòng kiểm tra Captcha
        ];
    }
    public function messages()
    {
        return [
            'emailLogin.required' => 'Email không được để trống',
            'passwordLogin.required' => 'Password không được để trống',
        ];
    }
}
