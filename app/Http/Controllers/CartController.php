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
use App\Traits\payment_Traits;
use App\User;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CartController extends Controller
{
    // use SendEmailOderSuccessQueue;
    use payment_Traits;
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
        $product_price = $product->price;
        if ($product->promotional_price != 0) {
            $product_price = $product->promotional_price;
        }
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
                        'price' => $product_price,
                        'image_path' => $product->feature_image_path,
                        'quantity' => $request->quantity
                    ];
                } else {
                    $cart[$id] = [
                        'name' => $product->name,
                        'price' => $product_price,
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
        session()->forget('voucher');
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
        // $carts = session()->get('cart');
        return view('cart.checkout', compact('thanhPhos'));
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

        $carts = session()->get('cart');
        // dd($carts);
        foreach ($carts as $cart) {
            $totalPrice += $cart['quantity'] * $cart['price'];
        }
        session()->put('totalPrice', $totalPrice); //tổng giá đơn hàng
        //giá trị voucher
        $priceVoucher = 0;
        if (isset($voucher)) {
            if ($voucher->type == 0) {
                if ($voucher->numberMax > 0) {
                    $priceVoucher = $voucher->numberMax;
                } else {
                    $priceVoucher = ($totalPrice * $voucher->number / 100);
                }
            } else {
                $priceVoucher = $voucher->number;
            }
        }
        $priceEnd = $totalPrice + $priceShip - $priceVoucher;

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

        if ($request->payment == 'Tiền mặt') {
            return $this->Payment_Traits($data_Oder, $carts, $voucher_id);
        } elseif ($request->payment == 'PayPal') {
            $priceDolla = round($priceEnd / 22830, 2);
            return redirect()->route('processTransaction', compact('priceDolla', 'data_Oder', 'carts', 'voucher_id'));
        } elseif ($request->payment == 'VNPAY') {
            session()->put('data_Oder', $data_Oder);
            session()->put('carts', $carts);
            session()->put('voucher_id', $voucher_id);
            return view('cart.VNPAY.transaction', compact('priceEnd'));
        }
    }
    public function paymentSuccess()  //giui email
    {
        $Oder_id = $this->oder->where('user_id', Auth()->id())->latest()->first();

        $to_email = Auth::user()->email; //gủi đến email người dùng
        if ($to_email != '') {
            // $this->SentMailSuccess();
            $from_name = "P-Shopper";
            $from_email = "nobita9cs6vk@gmail.com"; //gửi từ email

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
        // session()->forget('voucher');
        $codeCoupon = $request->data_coupon_code;
        $query = $this->voucher->where('code', $codeCoupon);
        $voucher = $query->first();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $viewTotalPriceRender = '';

        $messageCoupon = -1;
        if (isset($voucher)) {
            session()->forget('voucher');
            $user_id_crrent = Auth()->id();
            $count_user_id_crrent = 0;

            if ($voucher->quantity_use_of_user == 1) { //kiểm tra xem KH đã sử dụng chưa. Trường hợp mã giảm giá mỗi người chỉ sử dụng 1 lần sử dụng
                $checkUseVoucher = $query->where('user_id', 'LIKE', '%' . $user_id_crrent . '%')->first();
            } else {  //kiểm tra xem KH đã sử dụng chưa. Trường hợp mã giảm giá mỗi người sử dụng được nhiều hơn 1 lần sử dụng
                $user_ids = explode(' ', $voucher->user_id);
                foreach ($user_ids as $user_id) {
                    if ($user_id == $user_id_crrent) {
                        $count_user_id_crrent += 1;
                    }
                }
                // dd($user_ids);
            }

            if ($user_id_crrent == null) {
                $messageCoupon = -6; //người dùng chưa đăng nhập
            } elseif ($voucher->status == 1) {
                $messageCoupon = -2; //mã chưa kích hoạt
            } elseif ($now < $voucher->date_start) {
                $messageCoupon = -3; //mã chưa đến hạn
            } elseif ($now > $voucher->date_end) {
                $messageCoupon = -4; //mã đã hết hạn
            } elseif ($count_user_id_crrent >= $voucher->quantity_use_of_user || isset($checkUseVoucher)) {
                $messageCoupon = -5; //người dùng này đã hết lượt sử dụng
            } else {
                session()->put('voucher', $voucher);
                $messageCoupon = $voucher->quantity;
            }
            $carts = session()->get('cart');
            $viewTotalPriceRender = view('cart.components.totalPrice', compact('carts'))->render();
        }
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
