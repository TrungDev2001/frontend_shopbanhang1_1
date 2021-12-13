<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutValidate;
use App\Models\Oder;
use App\Models\OderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendEmailOderSuccessQueue;
use App\Models\QuanHuyen;
use App\Models\ThanhPho;
use App\Models\TransportFee;
use App\Models\Voucher;
use App\Models\XaPhuong;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // use SendEmailOderSuccessQueue;
    private $product;
    private $oder;
    private $oderDetail;
    private $thanhPho;
    private $quanHuyen;
    private $xaPhuong;
    private $transportFee;
    public function __construct(Product $product, Oder $oder, OderDetail $oderDetail, Voucher $voucher, ThanhPho $thanhPho, QuanHuyen $quanHuyen, XaPhuong $xaPhuong, TransportFee $transportFee)
    {
        $this->product = $product;
        $this->oder = $oder;
        $this->oderDetail = $oderDetail;
        $this->voucher = $voucher;
        $this->thanhPho = $thanhPho;
        $this->quanHuyen = $quanHuyen;
        $this->xaPhuong = $xaPhuong;
        $this->transportFee = $transportFee;
    }
    public function index()
    {
        return view('cart.cart');
    }
    public function add_to_cart($id, Request $request)
    {
        $product = $this->product->find($id);
        if ($product->quantity_product != 0) {
            $cart = session()->get('cart');
            if (isset($cart[$id]['quantity'])) {
                if (isset($request->quantity)) { //nếu có quantity khi mua hang trong trang detail
                    $cart[$id]['quantity'] = $cart[$id]['quantity'] + $request->quantity;
                } else {
                    $cart[$id]['quantity'] = $cart[$id]['quantity'] + 1;
                }
            } else {
                if (isset($request->quantity)) {
                    $cart[$id] = [
                        'name' => $product->name,
                        'price' => $product->price,
                        'image_path' => $product->feature_image_path,
                        'quantity' => $request->quantity
                    ];
                } else {
                    $cart[$id] = [
                        'name' => $product->name,
                        'price' => $product->price,
                        'image_path' => $product->feature_image_path,
                        'quantity' => 1
                    ];
                }
            }
            session()->put('cart', $cart);
            $cart = session()->get('cart');
            $numberCart = count($cart);

            return Response()->json([
                'status' => 200,
                'message' => 'Thêm vào giỏ hàng thành công.',
                'numberCart' => $numberCart
            ], 200);
        } else {
            return Response()->json([
                'status' => 400,
                'message' => 'Sản phẩm tạm thời hết hàng.',
            ], 200);
        }
    }

    public function show_cart()
    {
        //session()->flush('cart');
        $carts = session()->get('cart');
        $thanhPhos = $this->thanhPho->get();
        return view('cart.cart', compact('carts', 'thanhPhos'));
    }
    public function update_cart($id_Cart, Request $request)
    {
        $carts = session()->get('cart');
        $carts[$id_Cart]['quantity'] = $request->quantity;
        session()->put('cart', $carts);
        $carts = session()->get('cart');
        $viewCartRender = view('cart.cart_components', compact('carts'))->render();
        $viewTotalPriceRender = view('cart.components.totalPrice', compact('carts'))->render();
        return Response()->json([
            'status' => 200,
            'viewCartRender' => $viewCartRender,
            'viewTotalPriceRender' => $viewTotalPriceRender,
        ], 200);
    }
    public function delete_cart($id_Cart)
    {
        $carts = session()->get('cart');
        unset($carts[$id_Cart]);
        session()->put('cart', $carts);
        $carts = session()->get('cart');
        $viewCartRender = view('cart.cart_components', compact('carts'))->render();
        $viewTotalPriceRender = view('cart.components.totalPrice', compact('carts'))->render();
        $numberCart = count($carts);
        return Response()->json([
            'status' => 200,
            'viewCartRender' => $viewCartRender,
            'viewTotalPriceRender' => $viewTotalPriceRender,
            'numberCart' => $numberCart
        ], 200);
    }
    public function checkout()
    {
        $thanhPhos = $this->thanhPho->get();
        $carts = session()->get('cart');
        return view('cart.checkout', compact('carts', 'thanhPhos'));
    }
    public function payment(CheckoutValidate $request)
    {
        $voucher = session()->get('voucher');
        if (isset($voucher)) {
            $voucher_id = $voucher->id;
        } else {
            $voucher_id = 0;
        }

        $priceShip = session()->get('priceShip');

        $totalPrice = 0;
        $totalQuantity = 0;
        $carts = session()->get('cart');
        foreach ($carts as $cart) {
            $totalPrice += $cart['quantity'] * $cart['price'];
        }
        session()->put('totalPrice', $totalPrice); //tổng giá đơn hàng
        $data_Oder = [
            'user_id' => Auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'thanhpho' => $request->thanhpho,
            'quanhuyen' => $request->quanhuyen,
            'xaphuong' => $request->xaphuong,
            'sonha' => $request->sonha,
            'notes' => $request->notes,
            'coupon_id' => $voucher_id,
            'priceShip' => $priceShip,
            'payment' => $request->payment,
            'total_price' => $totalPrice,
        ];
        $oder_id = $this->oder->create($data_Oder);

        foreach ($carts as $product_id => $cart) {
            $totalQuantity += $cart['quantity'];

            $product = $this->product->find($product_id);
            $data_Oder_Detail = [
                'oder_id' => $oder_id->id,
                'product_id' => $product_id,
                'image_path' => $product->feature_image_path,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $cart['quantity'],
            ];
            $this->oderDetail->create($data_Oder_Detail);

            session()->put('totalQuantity', $totalQuantity); //đếm số hàng có trong giỏ
        }

        if (isset($voucher)) {
            $this->voucher->find($voucher_id)->update([
                'quantity' => $voucher->quantity - 1, //giảm số lượng voucher khi đặt hàng thành công
            ]);
        }

        session()->forget('cart');
        session()->forget('voucher');
        session()->forget('priceShip');
        return redirect()->route('cart.paymentSuccess');
    }
    public function paymentSuccess()  //giui email
    {
        $Oder_id = $this->oder->where('user_id', Auth()->id())->latest()->first();

        if (Auth::user()->email != '') {
            // $this->SentMailSuccess();
            $from_name = "P-Shopper";
            $from_email = "nobita9cs6vk@gmail.com"; //gửi từ email
            $to_email = Auth::user()->email; //gủi đến email người dùng

            $content_email = [
                'name' => 'Đặt hàng thành công.',
                'body' => 'Cảm ơn bạn đã mua hàng.'
            ];
            SendEmailOderSuccessQueue::dispatch($from_name, $from_email, $to_email, $content_email); //giui email bằng queue
            return view('cart.checkoutSuccess', compact('Oder_id'));
        } else {
            return view('cart.checkoutSuccess', compact('Oder_id'));
        }

        session()->forget('totalPrice');
        session()->forget('totalQuantity');
    }

    //test giui email
    public function SentMailSuccess()
    {
        $from_name = "P-Shopper";
        $from_email = "nobita9cs6vk@gmail.com"; //gửi từ email
        $to_email = Auth::user()->email; //gủi đến email người dùng

        $content_email = [
            'name' => 'Đặt hàng thành công.',
            'body' => 'Cảm ơn bạn đã mua hàng.'
        ];
        Mail::send('cart.sent_email', $content_email, function ($message) use ($from_name, $from_email, $to_email) { //view, array, function
            $message->to($to_email)->subject($from_name); //gửi đến email với tiêu đề chính
            $message->from($from_email, $from_name); //gửi từ
        });
        //https://www.youtube.com/watch?v=eTmiJLIrGRQ&t=548s
    }

    //mã giảm giá
    public function coupon_code(Request $request)
    {
        $codeCoupon = $request->data_coupon_code;
        $voucher = $this->voucher->where('code', $codeCoupon)->first();
        $messageCoupon = -1;
        if (isset($voucher)) {
            $messageCoupon = $voucher->quantity;
        }
        if ($voucher->quantity > 0) {
            session()->put('voucher', $voucher);
        } else {
            session()->forget('voucher');
        }
        $carts = session()->get('cart');
        $viewTotalPriceRender = view('cart.components.totalPrice', compact('carts', 'voucher'))->render();
        return Response()->json([
            'code' => 200,
            'viewTotalPriceRender' => $viewTotalPriceRender,
            'messageCoupon' => $messageCoupon
        ], 200);
    }

    //lấy address
    public function fecthAddress(Request $request)
    {
        $typeSelect = $request->type;
        $htmlAddress = 'Chọn';
        if ($typeSelect == 'thanhpho') {
            $quanHuyens = $this->quanHuyen->where('matp', $request->thanhpho)->get();
            foreach ($quanHuyens as $quanHuyen) {
                $htmlAddress .= '<option value="' . $quanHuyen->maqh . '">' . $quanHuyen->name . '</option>';
            }
        } else {
            $xaPhuongs = $this->xaPhuong->where('maqh', $request->quanhuyen)->get();
            foreach ($xaPhuongs as $xaPhuong) {
                $htmlAddress .= '<option value="' . $xaPhuong->xaid . '">' . $xaPhuong->name . '</option>';
            }
        }
        return Response()->json([
            'status' => 200,
            'htmlAddress' => $htmlAddress
        ]);
    }

    //Lấy phí vận chuyển
    public function fetchPriceShip(Request $request)
    {
        $transportFee = $this->transportFee->where('thanhpho', $request->thanhpho)->where('quanhuyen', $request->quanhuyen)->where('xaphuong', $request->xaphuong)->first();
        $priceShip = 0;
        if ($transportFee != null) {
            $priceShip = $transportFee->phivanchuyen;
        } else {
            $priceShip = 35000;
        }
        session()->put('priceShip', $priceShip);
        $carts = session()->get('cart');
        $voucher = session()->get('voucher');

        $viewTotalPriceRender = view('cart.components.totalPrice', compact('carts', 'voucher', 'priceShip'))->render();
        return Response()->json([
            'status' => 200,
            'priceShip' => $priceShip,
            'viewTotalPriceRender' => $viewTotalPriceRender,
        ]);
    }
}
