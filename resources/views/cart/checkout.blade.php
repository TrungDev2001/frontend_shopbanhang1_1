@php
	$base_url = config('base_url.url_backend.url');
	$totalPrice = 0;
@endphp
@extends('layouts.master')

@section('title', 'Checkout | P-Shopper')

@section('content')
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Thủ tục thanh toán</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="register-req">
				<p>Vui lòng sử dụng Đăng ký và Thanh toán để dễ dàng truy cập vào lịch sử đơn đặt hàng của bạn hoặc sử dụng Thanh toán với tư cách Khách</p>
			</div><!--/register-req-->


			<div class="review-payment">
				<h2>Xem lại & Thanh toán</h2>
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
                        @if (session()->has('cart'))
							@foreach (session()->get('cart') as $keyCart => $cart)
								@php
									$base_url = 'http://localhost:8000/';
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
											<p>{{ number_format($cart['price']) }} VND</p>
										</td>
										<td class="cart_quantity" data-url = {{ route('cart.update_cart', ['id' => $keyCart]) }}>
											<div class="cart_quantity_button">
												<input style="width: 60px;" class="cart_quantity_input" type="number" id="quantity" name="quantity" value="{{ $cart['quantity'] }}" min="1" autocomplete="off" size="1">
											</div>
										</td>
										<td class="cart_total">
											<p class="cart_total_price">{{ number_format($cart['price'] * $cart['quantity']) }} VND</p>
										</td>
									</tr>
							@endforeach    
                        @endif
                            <tr>
                                <td colspan="4">&nbsp;</td>
                                <td colspan="2">
                                    <table class="table table-condensed total-result">
                                        {{-- <tr>
                                            <td>Tổng tiền hàng</td>
                                            <td>{{ number_format($totalPrice) }}đ</td>
                                        </tr>
                                        <tr class="shipping-cost">
                                            <td>Tổng tiền phí vận chuyển</td>
                                            <td class="priceShip">đ</td>									
                                        </tr>
                                        <tr>
                                            <td>Thành tiền</td>
                                            <td><span>{{ number_format($totalPrice) }}đ</span></td>
                                        </tr> --}}

										<div class="total_area">
											<ul id="totalPrice">
												@include('cart.components.totalPrice')
											</ul>
										</div>
                                    </table>
                                </td>
                            </tr>
					</tbody>
				</table>

			</div>

			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-12">

						@if(\Session::has('error'))
							<div class="alert alert-danger">{{ \Session::get('error') }}</div>
							{{ \Session::forget('error') }}
						@endif
						@if(\Session::has('success'))
							<div class="alert alert-success">{{ \Session::get('success') }}</div>
							{{ \Session::forget('success') }}
						@endif

						<div class="shopper-info">
							<p>Thông tin người mua hàng</p>
							<form method="POST" action="{{ route('cart.payment') }}">
								@csrf
								<input type="text" name="name" class="@error('name') is-invalid @enderror" placeholder="Tên khách hàng">
									@error('name')
										<div class="text-danger">{{ $message }}</div>
									@enderror
								<input type="number" name="phone" class="@error('phone') is-invalid @enderror" placeholder="Số điện thoại">
									@error('phone')
										<div class="text-danger">{{ $message }}</div>
									@enderror

								<input type="text" name="message" name="notes" placeholder="Ghi chú về đơn đặt hàng của bạn, Ghi chú đặc biệt khi giao hàng.">

								<ul class="user_info">
									<li class="single_fiel">
										<label>Tỉnh thành phố</label>
										<select class="thanhpho choose @error('thanhpho') is-invalid @enderror" name="thanhpho" id="thanhpho">
											<option value="">Chọn thành phố</option>
											@foreach ($thanhPhos as $thanhPho)
												<option value="{{ $thanhPho->matp }}">{{ $thanhPho->name }}</option>
											@endforeach
										</select>
										@error('thanhpho')
											<div class="text-danger">{{ $message }}</div>
										@enderror
									</li>
									<li class="single_fiel">
										<label>Quận huyện</label>
										<select class="quanhuyen choose @error('quanhuyen') is-invalid @enderror" name="quanhuyen" id="quanhuyen">
											<option value="">Chọn quận huyện</option>
										</select>
										@error('quanhuyen')
											<div class="text-danger">{{ $message }}</div>
										@enderror
									</li>
									<li class="single_fiel">
										<label>Xã phường</label>
										<select class="xaphuong @error('xaphuong') is-invalid @enderror" name="xaphuong">
											<option value="">Chọn xã phường</option>
										</select>
										@error('xaphuong')
											<div class="text-danger">{{ $message }}</div>
										@enderror
									</li>
									<li class="single_fiel zip-field">
										<label>Số nhà</label>
										<input type="text" class="@error('sonha') is-invalid @enderror" name="sonha">
										@error('sonha')
											<div class="text-danger">{{ $message }}</div>
										@enderror
									</li>
									<li>
								 		<small class="form-text text-success messagePriceShip" style="display: none">Phí vận chuyển: <span id="priceShip"></span>đ</small>
									</li>
								</ul>

								<div style="margin: 5px 0px; display: inline-flex;" class="payment-options">
									<p style="margin-right: 20px;">Phương thức thanh toán:</p>
									<span>
										<label><input type="radio" value="Tiền mặt" name="payment" class="@error('payment') is-invalid @enderror"> Thanh toán khi nhận hàng</label>
											@error('payment')
												<div class="text-danger">{{ $message }}</div>
											@enderror
									</span>
									<span>
										<label><input type="radio" value="PayPal" name="payment">PayPal</label>
										<label><input type="radio" value="VNPAY" name="payment">VNPAY</label>
									</span>
								</div>
								<button class="btn btn-primary" type="submit" style="display: block;">Đặt hàng</button>
							</form>
							
						</div>
					</div>				
				</div>
			</div>
		</div>

	</section> <!--/#cart_items-->
@endsection

@section('js')
	<script src="{{asset('FrontEnd/Card/Checkout/checkout.js')}}"></script>
@endsection





