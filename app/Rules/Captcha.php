<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use ReCaptcha\ReCaptcha;

class Captcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //'CAPTCHA_SECRET Locahost: 6LfHYKEcAAAAACgsgin-UlBmpg_jIbdQ2wXxGePX
        //'CAPTCHA_SECRET herpku: 6LeXoqAeAAAAAEWgo-1I1NPT1L5vuhLKssqryYfT
        $recaptcha = new ReCaptcha('6LeXoqAeAAAAAEWgo-1I1NPT1L5vuhLKssqryYfT');
        $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);
        return $response->isSuccess();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Vui lòng hoàn thành recaptcha để gửi đăng nhập.';    //trả về thông báo khi lỗi không xác nhận captcha
    }
}
