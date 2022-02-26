<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Models\Oder;
use App\Models\OderDetail;
use App\Models\Voucher;
use App\Models\Product;
use App\Models\VnpayPayment;

trait payment_Traits
{
    private $oder;
    private $oderDetail;
    private $voucher;
    private $vnpayPayment;
    public function __construct(Product $product, Oder $oder, OderDetail $oderDetail, Voucher $voucher, VnpayPayment $vnpayPayment)
    {
        $this->product = $product;
        $this->oder = $oder;
        $this->oderDetail = $oderDetail;
        $this->voucher = $voucher;
        $this->vnpayPayment = $vnpayPayment;
    }
    public function Payment_Traits($data_Oder, $carts, $voucher_id, $data_VNPAY_return = '')
    {
        try {
            DB::beginTransaction();
            $totalQuantity = 0;
            $oder_id = $this->oder->create($data_Oder);

            foreach ($carts as $product_id => $cart) {
                $totalQuantity += $cart['quantity'];

                $product = $this->product->find($product_id);
                $product_price = $product->price;
                if ($product->promotional_price != 0) {
                    $product_price = $product->promotional_price;
                }
                $data_Oder_Detail = [
                    'oder_id' => $oder_id->id,
                    'product_id' => $product_id,
                    'image_path' => $product->feature_image_path,
                    'name' => $product->name,
                    'price' => $product_price,
                    'quantity' => $cart['quantity'],
                ];
                $this->oderDetail->create($data_Oder_Detail);

                session()->put('totalQuantity', $totalQuantity); //đếm số hàng có trong giỏ
            }

            if (isset($voucher)) {
                $this->voucher->find($voucher_id)->update([
                    'quantity' => $voucher->quantity - 1, //giảm số lượng voucher khi đặt hàng thành công
                    'user_id' => $voucher->user_id . Auth()->id() . ' ',
                ]);
            }
            $user = User::find(Auth()->id());
            $user->update([
                'count_buy' => $user->count_buy++, //cập nhập sô lần khách đã mua
            ]);

            session()->forget('cart');
            session()->forget('voucher');
            session()->forget('priceShip');

            //payment VNPAY
            if ($data_Oder['payment'] == 'VNPAY') {
                $data_VNPAY_return['oder_id'] = $oder_id->id;
                $this->vnpayPayment->create($data_VNPAY_return);
                session()->forget('data_Oder');
                session()->forget('carts');
                session()->forget('voucher_id');
            }
            DB::commit();
            return redirect()->route('cart.paymentSuccess');
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = Log::error('Message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }
}
