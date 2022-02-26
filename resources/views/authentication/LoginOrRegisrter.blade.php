@php
	$base_url = config('base_url.url_backend.url');
@endphp
@extends('layouts.master')

@section('title', 'Login | P-Shopper')

@section('content')
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Đăng nhập vào tài khoản của bạn</h2>
						@if (session('loginFail'))
							<p class="text-danger">{{ session('loginFail') }}</p>
						@endif
						<form action="{{ route('login') }}" method="POST">
							@csrf
							<input type="email" name="emailLogin" class="@error('emailLogin') is-invalid @enderror" placeholder="Địa chỉ email" />
							@error('emailLogin')
								<div class="text-danger">{{ $message }}</div>
							@enderror

							<input type="password" name="passwordLogin" class="@error('passwordLogin') is-invalid @enderror" placeholder="Mật khẩu"/>
							@error('passwordLogin')
								<div class="text-danger">{{ $message }}</div>
							@enderror
							<!-- CAPTCHA_KEY locahost: 6LfHYKEcAAAAAN-_pe1ckUWAlCBZJt3sPcl9nnpx-->
							<!-- CAPTCHA_KEY heruku: 6LeXoqAeAAAAAOmebLh5CJe07ron872Wnr7R_NgS-->
							{{-- <div class="g-recaptcha" data-sitekey="6LeXoqAeAAAAAOmebLh5CJe07ron872Wnr7R_NgS"></div>
							<br/>
							@if($errors->has('g-recaptcha-response'))
							<span class="invalid-feedback text-danger" style="display:block">
								<strong>{{$errors->first('g-recaptcha-response')}}</strong>
							</span>
							@endif --}}

							<span>
								<input type="checkbox" class="checkbox"> 
								Giữ cho tôi đăng nhập
							</span>
							<button type="submit" class="btn btn-default">Đăng nhập</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">Hoặc</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Đăng ký người dùng mới!</h2>
						<form id="dangki" action="{{ route('register') }}" method="POST">
							@csrf
							<input type="text" name="name" class="@error('name') is-invalid @enderror" placeholder="Tên"/>
							@error('name')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
							<input type="email" name="email" class="@error('email') is-invalid @enderror" placeholder="Địa chỉ email"/>
							@error('email')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
							<input type="password" name="password" class="@error('password') is-invalid @enderror" placeholder="Mật khẩu"/>
							@error('password')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror

							{{-- <div class="g-recaptcha" data-sitekey="6LeXoqAeAAAAAOmebLh5CJe07ron872Wnr7R_NgS"></div>
							<br/>
							@if($errors->has('g-recaptcha-response'))
							<span class="invalid-feedback text-danger" style="display:block">
								<strong>{{$errors->first('g-recaptcha-response')}}</strong>
							</span>
							@endif --}}

							<button type="submit" class="btn btn-default">Đăng kí</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
@endsection

@section('js')
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection



