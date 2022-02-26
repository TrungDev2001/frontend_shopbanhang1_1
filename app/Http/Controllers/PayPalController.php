<?php

namespace App\Http\Controllers;

use App\Traits\payment_Traits;
use Illuminate\Http\Request;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    use payment_Traits;
    /**
     * create transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        return view('cart.paypal.transaction');
    }

    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        $data_Oder = $request->data_Oder;
        $carts = $request->carts;
        $voucher_id = $request->voucher_id;

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction', compact('data_Oder', 'carts', 'voucher_id')),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->priceDolla,
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('cart.checkout')
                ->with('error', 'Đã xảy ra sự cố.');
        } else {
            return redirect()
                ->route('cart.checkout')
                ->with('error', $response['message'] ?? 'Đã xảy ra sự cố.');
        }
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return $this->Payment_Traits($request->data_Oder, $request->carts, $request->voucher_id);
            // return redirect()
            //     ->route('cart.checkout')
            //     ->with('success', 'Giao dịch hoàn tất.');
        } else {
            return redirect()
                ->route('cart.checkout')
                ->with('error', $response['message'] ?? 'Đã xảy ra sự cố.');
        }
    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('cart.checkout')
            ->with('error', $response['message'] ?? 'Bạn đã hủy giao dịch.');
    }
}
