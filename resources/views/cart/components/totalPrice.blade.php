@if (session()->has('cart'))
    @php
        $carts = session()->get('cart');
        $totalPrice = 0;
        if (session()->get('voucher')) {
            $voucher = session()->get('voucher');
        }
    @endphp
    @foreach ($carts as $cart)
        @php
            $totalPrice +=  $cart['price'] * $cart['quantity'];
        @endphp
    @endforeach

    <li>Tổng tiền hàng <span>{{ number_format($totalPrice, 0, ',','.') }}đ</span></li>
    @if (isset($voucher->number) && $voucher->quantity>0)
        @php
            if ($voucher->type=='%') {
                if($voucher->numberMax>0){
                    $pricePhanTram = $voucher->numberMax;
                }else{
                    $pricePhanTram = $totalPrice*$voucher->number/100;
                }
            }else{
                $priceTien = $voucher->number;
            }
        @endphp
        @if ($voucher->type=='%')
            <li>Mã khuyến mãi {{$voucher->number}}% {{ $voucher->numberMax>0 ? '(Tối đa '.number_format($voucher->numberMax,0,',','.').'đ)' : '' }}<span>-{{ number_format($pricePhanTram,0,',','.') }}đ</span></li>
        @else
            <li>Mã khuyến mãi {{number_format($voucher->number,0,',','.')}}đ<span>-{{ number_format($priceTien,0,',','.') }}đ</span></li>
        @endif
    @endif
    <li style="display: {{ isset($priceShip) ? 'block' : 'none' }}" >Phí vận chuyển <span>{{ number_format(isset($priceShip) ? $priceShip : 0, 0 ,',','.') }}đ</span></li>
    @if (isset($voucher->number) && $voucher->quantity>0)
        @if ($voucher->type=='%')
            <li>Thành tiền <span>{{ number_format($totalPrice - $pricePhanTram + (isset($priceShip) ? $priceShip : 0), 0,',','.') }}đ</span></li>
        @else
            <li>Thành tiền <span>{{ number_format($totalPrice-$priceTien<=0?'0':$totalPrice-$priceTien  + (isset($priceShip) ? $priceShip : 0) , 0,',','.') }}đ</span></li>
        @endif
    @else
        <li>Thành tiền <span>{{ number_format($totalPrice + (isset($priceShip) ? $priceShip : 0), 0,',','.') }}đ</span></li>
    @endif
@else
    <li>Tổng tiền hàng <span>0đ</span></li>
    <li>Phí vận chuyển <span>{{ number_format(isset($priceShip) ? $priceShip : 0, 0 ,',','.') }}đ</span></li>
    <li>Thành tiền <span>0đ</span></li>
@endif