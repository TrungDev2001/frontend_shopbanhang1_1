<?php

namespace App\Http\Controllers;

use App\Traits\payment_Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VNPAYController extends Controller
{
    use payment_Traits;
    public function processVNPAY(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        //dd($voucher_id);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay_return');
        $vnp_TmnCode = "SQA2RU75"; //Mã website tại VNPAY 
        $vnp_HashSecret = "KDXJFWIRQYQRAAFFOQGJFSRJNXQJNLTI"; //Chuỗi bí mật
        $vnp_TxnRef = Str::random(6); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $request->OrderDescription . 'Thanh toan don hang thoi gian: ' . Carbon::now('Asia/Ho_Chi_Minh');
        $vnp_OrderType = $request->ordertype;
        $vnp_Amount = $request->pricePayment * 100;
        $vnp_Locale = $request->language;
        $vnp_BankCode = $request->bankcode;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }
    public function vnpay_return(Request $request)
    {
        $data_Oder = session()->get('data_Oder');
        $carts = session()->get('carts');
        $voucher_id = session()->get('voucher_id');
        $data_VNPAY_return = [
            'vnp_Amount' => $request->vnp_Amount,
            'vnp_BankCode' => $request->vnp_BankCode,
            'vnp_BankTranNo' => $request->vnp_BankTranNo,
            'vnp_CardType' => $request->vnp_CardType,
            'vnp_OrderInfo' => $request->vnp_OrderInfo,
            'vnp_PayDate' => $request->vnp_PayDate,
            'vnp_ResponseCode' => $request->vnp_ResponseCode,
            'vnp_TmnCode' => $request->vnp_TmnCode,
            'vnp_TransactionNo' => $request->vnp_TransactionNo,
            'vnp_TransactionStatus' => $request->vnp_TransactionStatus,
            'vnp_TxnRef' => $request->vnp_TxnRef,
        ];
        return $this->Payment_Traits($data_Oder, $carts, $voucher_id, $data_VNPAY_return);
    }
}
