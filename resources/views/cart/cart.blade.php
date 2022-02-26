<?php
	$base_url = config('base_url.url_backend.url');
$totalPrice = 0;
?>
@extends('layouts.master')

@section('title', 'Cart | P-Shopper')

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Giỏ hàng</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Ảnh</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                   
                    <div class="cart-wapper">
                        @include('cart.cart_components')
                    </div>
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>Thông tin vận chuyển?</h3>
            <p>Chọn xem bạn có mã giảm giá hoặc điểm thưởng muốn sử dụng hoặc muốn ước tính chi phí giao hàng của mình.</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="chose_area">
                    <ul class="user_option">
                        <li>
                            <input type="checkbox" name="coupon" id="coupon">
                            <label for="coupon">Sử dụng mã phiếu giảm giá</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Sử dụng phiêu qua tặng</label>
                        </li>
                        <li>
                            <input type="checkbox" id="vanchuyen" checked>
                            <label for="vanchuyen">Ước tính hàng & Thuế</label>
                        </li>
                    </ul>
                    <ul class="coupon_code" style="display: none">
                        @php
                            if (session()->has('voucher')) {
                                $voucher = session()->get('voucher');
                            }
                        @endphp
                        <li><input type="text" value="{{ isset($voucher->code) ? $voucher->code : '' }}" class="form-control" id="coupon_codee" placeholder="Nhập mã giảm giá"></li>
                        <small><p class="messageCoupon text-danger"></p></small>
                    </ul>
                    <ul class="user_info" style="display: none">
                        <li class="single_field">
                            <label>Tỉnh thành phố</label>
                            <select class="thanhpho choose" name="thanhpho" id="thanhpho">
                                @foreach ($thanhPhos as $thanhPho)
                                    <option>Chọn thành phố</option>
                                    <option value="{{ $thanhPho->matp }}">{{ $thanhPho->name }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="single_field">
                            <label>Quận huyện</label>
                            <select class="quanhuyen choose" name="quanhuyen" id="quanhuyen">
                                <option>Chọn quận huyện</option>
                            </select>
                        </li>
                        <li class="single_field">
                            <label>Xã phường</label>
                            <select class="xaphuong" name="xaphuong">
                                <option>Chọn xã phường</option>
                            </select>
                        </li>
                        {{-- <li class="single_field zip-field">
                            <label>Zip Code:</label>
                            <input type="text">
                        </li> --}}
                    </ul>
                    <a class="btn btn-default update" href="">Get Quotes</a>
                    <a class="btn btn-default check_out" href="">Continue</a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul id="totalPrice">
                        @include('cart.components.totalPrice')
                    </ul>
                        {{-- <a class="btn btn-default update" href="">Update</a> --}}
                        <a class="btn btn-default check_out" href="{{ route('cart.checkout') }}">Thanh toán</a>
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->
@endsection

@section('js')
<script>
    $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});



    function checkedFormVanchuyen(){
                if($('#vanchuyen').is(":checked")){
            $('.user_info').show();
        }else{
            $('.user_info').hide();
        }
    }
    checkedFormVanchuyen();

    $(document).on('click', '#coupon, #vanchuyen', function(){
        if($('#coupon').is(":checked")){
            $('.coupon_code').show();
        }else{
            $('.coupon_code').hide();
        }

        if($('#vanchuyen').is(":checked")){
            $('.user_info').show();
        }else{
            $('.user_info').hide();
        }
    });
    $(document).on('change', '#coupon_codee', function(){
        var data_coupon_code = $(this).val();
        var url = "Card/CouponCode";
        $.ajax({
            type: "post",
            url: url,
            data: {data_coupon_code: data_coupon_code},
            success: function (response) {
                if(response.code == 200){
                    // $('#totalPrice').html('');
                    if(response.viewTotalPriceRender != ''){
                        $('#totalPrice').html(response.viewTotalPriceRender);
                    }
                    if(response.messageCoupon == 0){
                        $('.messageCoupon').html('Mã khuyến mại đã hết.');
                    }else if(response.messageCoupon == -1){
                        $('.messageCoupon').html('Mã khuyến mại không đúng.');
                    }else if(response.messageCoupon > 0){
                        $('.messageCoupon').html('');
                    }else if(response.messageCoupon == -2){
                        $('.messageCoupon').html('Mã khuyến mãi này chưa được kích hoạt');
                    }else if(response.messageCoupon == -3){
                        $('.messageCoupon').html('Mã khuyến mãi này chưa đến ngày sử dụng');
                    }else if(response.messageCoupon == -4){
                        $('.messageCoupon').html('Mã khuyến mãi này đã hết hạn sử dụng');
                    }else if(response.messageCoupon == -5){
                        $('.messageCoupon').html('Mã khuyến mãi này bạn đã sử dụng hết lượt');
                    }else if(response.messageCoupon == -6){
                        $('.messageCoupon').html('Vui lòng đăng nhập để nhập mã giảm giá');
                    }
                }   
            }
        });
    })


    function update_cart(){ //update không bấm nút tăng giảm 2 bên
        var url = $(this).parents('tr').find('.cart_quantity').attr('data-url');
        var quantity = $(this).val();
        alert(quantity)
        $.ajax({
            type: "post",
            url: url,
            data: {quantity: quantity},
            dataType: "json",
            success: function (response) {
                if(response.status == 200){
                    $('tbody').html(response.viewCartRender);
                    $('#totalPrice').html(response.viewTotalPriceRender);
                }
            }
        });
	}
    function delete_cart(event){
        event.preventDefault();
        var url = $(this).attr('data-url');
        $.ajax({
            type: "delete",
            url: url,
            dataType: "json",
            success: function (response) {
                $('#totalPrice').html(response.viewTotalPriceRender);
                $('.cartt').html(response.numberCart);
                if(response.viewCartRender == ''){
                    $('tbody').html('<tr><td colspan="5"><p style="text-align: center">Làm ơn thêm sản phẩm vào giỏ hàng.</p></td></tr>');
                }else{
                    $('tbody').html(response.viewCartRender);
                }
            }
        });
    }
	$(document).on('change', '#quantity', update_cart);
    $(document).on('click', '.cart_quantity_delete', delete_cart);

//nút tăng giảm quantity
    $(document).on('click', '.cart_quantity_up', function(){
        var quantity = $(this).parents('.cart_quantity').find('.cart_quantity_input').val();
        if(quantity!=''){
            quantity++;
            $(this).parents('.cart_quantity').find('.cart_quantity_input').val(quantity);
        }
    });
    $(document).on('click', '.cart_quantity_down', function(){
        var quantity = $(this).parents('.cart_quantity').find('.cart_quantity_input').val();
        if(quantity!='' && quantity>1){
            quantity--;
            $(this).parents('.cart_quantity').find('.cart_quantity_input').val(quantity);
        }
    });
    function update_cart(){
        var quantity = $(this).parents('.cart_quantity').find('.cart_quantity_input').val();
        var url = $(this).parents('tr').find('.cart_quantity').attr('data-url');
        $.ajax({
            type: "post",
            url: url,
            data: {quantity: quantity},
            dataType: "json",
            success: function (response) {
                if(response.status == 200){
                    $('tbody').html(response.viewCartRender);
                    $('#totalPrice').html(response.viewTotalPriceRender);
                }
            }
        });
    };
    $(document).on('click', '.cart_quantity_up, .cart_quantity_down', update_cart);
</script>
<script src="{{asset('FrontEnd/Card/Checkout/checkout.js')}}"></script>
@endsection






