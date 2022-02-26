{{-- @if ($carts) --}}
@if (session()->has('cart'))
@foreach ($carts as $keyCart => $cart)
@php
	$base_url = config('base_url.url_backend.url');
    $totalPrice = 0;
    $totalPrice +=  $cart['price'] * $cart['quantity'];
@endphp
    <tr>
        <td class="cart_product">
            <a href=""><img src="{{ $base_url.$cart['image_path'] }}" alt=""></a>
        </td>
        <td class="cart_description">
            <h4><a href="">{{ $cart['name'] }} </a></h4>
        </td>
        <td class="cart_price">
            <p>{{ number_format($cart['price'], 0, ',', '.') }}đ</p>
        </td>
        <td class="cart_quantity" data-url = {{ route('cart.update_cart', ['id' => $keyCart]) }}>
            <div class="cart_quantity_button">
                <a class="cart_quantity_up"> + </a>
                <input style="width: 60px;" class="cart_quantity_input" type="number" id="quantity" name="quantity" value="{{ $cart['quantity'] }}" min="1" autocomplete="off" size="1">
                <a class="cart_quantity_down"> - </a>
            </div>
        </td>
        <td class="cart_total">
            <p class="cart_total_price">{{ number_format($cart['price'] * $cart['quantity'], 0, ',', '.') }}đ</p>
        </td>
        <td class="cart_delete">
            <a class="cart_quantity_delete" data-url="{{ route('cart.delete_cart', ['id' => $keyCart]) }}"><i class="fa fa-times"></i></a>
        </td>
    </tr>
@endforeach  
@else  
    <tr>
        <td colspan="5" align="center">Chưa có sản phẩm nào.</td>
    </tr>
@endif

