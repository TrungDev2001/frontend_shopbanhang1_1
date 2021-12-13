<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutValidate extends FormRequest
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
            'name' => 'required',
            'phone' => 'required',
            'thanhpho' => 'required',
            'quanhuyen' => 'required',
            'xaphuong' => 'required',
            'sonha' => 'required',
            'phone' => 'required',
            'payment' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name không được để trống',
            'phone.required' => 'Phone không được để trống',
            'thanhpho.required' => 'Thành phố không được để trống',
            'quanhuyen.required' => 'Quận huyện không được để trống',
            'xaphuong.required' => 'Xã phường không được để trống',
            'sonha.required' => 'Số nhà không được để trống',
            'phone.required' => 'Phone không được để trống',
            'payment.required' => 'Payment không được để trống',
        ];
    }
}
