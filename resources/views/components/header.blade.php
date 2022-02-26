@php
	$countCart = 0;
	if(is_array(session()->get('cart'))){
		$countCart = count(session()->get('cart'));
	}else{
		$countCart = 0;
	}
@endphp
<header id="header"><!--header-->
	<div class="header_top"><!--header_top-->
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="contactinfo">
						<ul class="nav nav-pills">
							<li><a href="#"><i class="fa fa-phone"></i> {{ $contact->phone }}</a></li>
							<li><a href="#"><i class="fa fa-envelope"></i> {{ $contact->email_link }}</a></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="social-icons pull-right">
						<ul class="nav navbar-nav">
							<li><a href="{{ $contact->fb_link }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="{{ $contact->twitter_link }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<li><a href="{{ $contact->youtube_link }}" target="_blank"><i class="fa fa-youtube fa-linkedin"></i></a></li>
							{{-- <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li> --}}
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div><!--/header_top-->
	
	<div class="header-middle"><!--header-middle-->
		<div class="container">
			<div class="row">
				<div class="col-md-4 clearfix">
					<div class="logo pull-left">
						<a href="{{ route('home.index') }}"><img src="{{asset('eshopper/images/home/logo1.png')}}" alt="" /></a>
					</div>

				</div>
				<div class="col-md-8 clearfix">
					<div class="shop-menu clearfix pull-right">
						<ul class="nav navbar-nav">
							{{-- <li><a href=""><i class="fa fa-user"></i> Account</a></li> --}}
							<li><a href="{{ route('home.header.wishlist') }}"><i class="fa fa-star"></i> Yêu thích</a></li>
							<li><a href="{{ route('home.header.bought') }}"><i class="fa fa-crosshairs"></i> Đơn hàng</a></li>
							<li><a class="cart" href="{{ route('cart.show_cart') }}"><i class=" fa fa-shopping-cart"></i><span class="badge badge-success cartt"><p>{{ $countCart }}</p></span> Giỏ hàng</a></li>
							@if (auth()->check()) {{-- session()->has('login') --}}
								<li><a href="{{ route('logout') }}"><i class="fa fa-lock"></i> Đăng xuất</a></li>
							@else
								<li><a href="{{ route('login.index') }}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
							@endif
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div><!--/header-middle-->

	<div class="header-bottom"><!--header-bottom-->
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<div class="mainmenu pull-left">
						<ul class="nav navbar-nav collapse navbar-collapse">
							<li><a href="{{ route('home.index') }}" class="active">Home</a></li>
							{{-- <li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
								<ul role="menu" class="sub-menu">
									<li><a href="{{ route('home.header.wishlist') }}">Sản phẩm yêu thích</a></li> 
									<li><a href="{{ route('home.header.bought') }}">Lịch sử mua hàng</a></li> 
									<li><a href="{{ route('cart.show_cart') }}">Giỏ hàng</a></li>
								</ul>
							</li>  --}}
							<li class="dropdown"><a href="{{ route('blog.index') }}">Tin tức</a>
							<li class="dropdown"><a href="{{ route('home.video.index') }}">Video</a>
								{{-- <ul role="menu" class="sub-menu">
									<li><a href="blog.html">Blog List</a></li>
									<li><a href="blog-single.html">Blog Single</a></li>
								</ul> --}}
							</li>
							<li><a href="{{ route('contact.index') }}">Liên hệ</a></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="search_box">
						<form action="{{ route('home.header.search_product_result') }}" autocomplete="off" method="post" style="display: flex;">
							@csrf
							<input type="text" name="input_search" id="input_search" placeholder="Search"/>
							<button type="submit" class="btn btn-info">Search</button>
						</form>
						<div>
							<style>
								.search_box form {
									margin-bottom: 0px;
								}
								ul#results_search {
									background-color: #f7f7f0;
									padding-left: 10px;
								}
								ul#results_search li:hover{
									background-color: #eee;
									color: #000;
									font-weight: bold;
								}
							</style>
							<ul id="results_search">
	
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!--/header-bottom-->
</header><!--/header-->