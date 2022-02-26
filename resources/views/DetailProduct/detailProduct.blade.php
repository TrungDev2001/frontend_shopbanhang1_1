<?php
	$base_url = config('base_url.url_backend.url');
?>
@extends('layouts.master')

@section('title', 'Product Details | P-Shopper')
@section('css')
	<link rel="stylesheet" href="{{ asset('vendors/lightslider/lightgallery.min.css') }}">
	<link rel="stylesheet" href="{{ asset('vendors/lightslider/lightslider.css') }}">

	<link rel="stylesheet" href="{{ asset('vendors/rating_star/rateyo.min.css') }}">
@endsection
@section('ShareFB')
<meta property="og:url"           content="{{ $url_DetailProduct }}" />
<meta property="og:type"          content="Shopping" />
<meta property="og:title"         content="{{ $product->name }}" />
<meta property="og:description"   content="{!! $product->description !!}" />
<meta property="og:image"         content="{{ $base_url.$product->feature_image_path }}" />
@endsection

@section('content')
	<section>
		{{-- Sản phẩm đã xem --}}
		<input type="hidden" name="" class="productWatched"
			data-product_id="{{ $product->id }}"
			data-product_name="{{ Str::words($product->name, 9) }}"
			data-product_price="{{ number_format($product->promotional_price > 0 ? $product->promotional_price : $product->price, 0, ',', '.') }}"
			data-feature_image_path="{{ $base_url.$product->feature_image_path }}"
			data-url_DetailProduct="{{ route('ProductDetail', ['id' => $product->id, 'slug' => $product->slug]) }}"
			data-url_addToCard="{{ route('add_to_cart.index', ['id' => $product->id])}}"
		>

		<div class="container">
			<div class="row">
				@include('home.components.sidebar')
				<style>
					li.active {
						border: 1px solid #ffac30;
					}
					ol.breadcrumb {
						background-color: #ffffff;
					}
					li.breadcrumb-item.active {
						border: 1px solid rgb(255 255 255 / 8%);
					}
					li.breadcrumb-item a {
						color: black;
						font-weight: bold;
					}
					legend {
						font-size: 14px;
						font-weight: bold;
					}
					small#messageErrorStar {
						padding-left: 8px;
					}
					.media img {
						width: 64px;
						height: 64px;
						border-radius: 50%;
    					object-fit: cover;
					}
					#reviews button{
						background: #5bc0de;
						border-radius: 20px;
					}
					.mt .getCommentChildrent {
						color: #5bc0de;
					}
				</style>
				<div class="col-sm-9 padding-right">
					<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
							<li class="breadcrumb-item"><a href="{{ route('categoryProduct.shop', ['slug' => $productCategory->slug, 'id' => $productCategory->id]) }}">{{ $productCategory->name }}</a></li>
							<li class="breadcrumb-item"><a href="{{ route('brandProduct.shop', ['id' => $productBrand->id ]) }}">{{ $productBrand->name }}</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
						</ol>
					</nav>

					{{-- oday --}}
					@include('DetailProduct.quickview.index')
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li><a href="#details" data-toggle="tab">Chi tiết sản phẩm</a></li>
								<li class="active"><a href="#reviews" data-toggle="tab">Đánh giá sản phẩm (<span class="count_comment"></span>)</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade" id="details" >
								{!! $product->content !!}
							</div>
							
							<div class="tab-pane fade active in" id="reviews" >
								<div class="col-sm-12">
									<ul>
										<li><a href=""><i class="fa fa-user"></i>{{ isset(Auth::user()->name) ? Auth::user()->name : 'User' }}</a></li>
										<li><a href=""><i class="fa fa-clock-o"></i>{{ substr(substr(date('Y-m-d H:i:s'), -8), -0, 5) }}</a></li>
										<li><a href=""><i class="fa fa-calendar-o"></i>{{ date('d/m/Y', strtotime(substr(date('Y-m-d H:i:s'), 0, 10))) }}</a></li>
									</ul>

									{{-- <div class="fb-comments" data-href="{{ $url_DetailProduct }}" data-width="800" data-numposts="10"></div> --}}

									<p><b id="titleRating">Đánh giá sao cho sản phẩm:</b></p>
									<div style="display: flex;">
										<div id="rateYo1"></div>
										<div class="counter"></div>
										<input type="hidden" id="product_id" value="{{ $product->id }}">
										<input type="hidden" id="user_id" value="{{ Auth()->id() }}">
										<small id="messageErrorStar" class="text-danger"></small>
									</div>
									
									<br>
									<br>

									<div>
										<form id='FormDataComment' action="" method="POST">
											<div class="form-group">
												<label for="exampleFormCotrolTextarea1">Viết đánh giá của bạn: </label>

												<input type="hidden" class="product_id" name="product_id" value="{{ $product->id }}">
												<textarea class="form-control contentComment11" name="contentComment" id="exampleFormCotrolTextarea1" placeholder="Viết đánh giá của bạn" style="margin-bottom: 5px; height: 3.6em; margin-top: 0px; border-radius: 20px;"></textarea>
												@if ($checkLogin)
													<button type="button" class="btn btn-info buttonComment">Gửi bình luận</button>
													<small class="text-success messageComment"></small>
												@else
													<button type="button" class="btn btn-info LoginAndComment" data-toggle="modal" data-target="#LoginAndComment">Đăng nhập ngay để bình luận</button>
												@endif
											</div>
										</form>
									</div>
									<br>

									<label for="exampleFormControlTextarea1">Đánh giá của sản phẩm: </label> đã có (<span class="count_comment"></span>) đánh giá
									<img class="img-loading-content" src="{{ asset('eshopper\images\loding-gif\loading5.gif') }}" style="width: 200px;margin-left: auto; margin-right: auto; display: block;" alt="">
									<div id="comments"></div>
									<img id="img-loading-content" src="{{ asset('eshopper\images\loding-gif\loading5.gif') }}" style="width: 200px;margin-left: auto; margin-right: auto; display: block; display: none;" alt="">
									<div id="comments_html_paginate"></div>
									{{-- @include('DetailProduct/comment/comment') --}}

								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">Sản phẩm liên quan</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
							@if (count($productRelates)==6)
								@foreach ($productRelates as $keyProductRelate => $productRelate)
									@if ($keyProductRelate%3 == 0)
										<div class="item {{$keyProductRelate==0 ? 'active' : ''}}">
									@endif
										<div class="col-sm-4">
											<div class="product-image-wrapper">
												<div class="single-products">
													<div class="productinfo text-center">
														<a href="{{ route('ProductDetail', ['id' => $productRelate->id, 'slug' => $productRelate->slug]) }}">
															<img style="height: 200px; object-fit: contain; object-position: left;" src="{{ $base_url.$productRelate->feature_image_path }}" alt="{{ $productRelate->feature_image_name }}" />
															<h2>{{ number_format($productRelate->price, 0 ,',','.') }}đ</h2>
															<p>{{ Str::words($productRelate->name,6) }}</p>
														</a>
														{{-- <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button> --}}
														<div style="display: flex;">
															<a data-url="{{ route('add_to_cart.index', ['id' => $product->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a>
															<a data-product_id="{{ $product->id }}" data-slug="{{ $product->slug }}" class="btn btn-default quickview-product" data-toggle="modal" data-target="#quickview"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning" viewBox="0 0 16 16">
																<path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641l2.5-8.5zM6.374 1 4.168 8.5H7.5a.5.5 0 0 1 .478.647L6.78 13.04 11.478 7H8a.5.5 0 0 1-.474-.658L9.306 1H6.374z"/>
																</svg>Xem nhanh
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									@if ($keyProductRelate%3 == 2)
										</div>
									@endif
									@break($keyProductRelate == 3)			
								@endforeach
								<a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>							
							@else
								@foreach ($productRelates->take(3) as $keyProductRelate => $productRelate)
									@if ($keyProductRelate%3 == 0)
										<div class="item {{$keyProductRelate==0 ? 'active' : ''}}">
									@endif
										<div class="col-sm-4">
											<div class="product-image-wrapper">
												<div class="single-products">
													<div class="productinfo text-center">
														<a href="{{ route('ProductDetail', ['id' => $productRelate->id, 'slug' => $productRelate->slug]) }}">
															<img style="height: 200px; object-fit: contain; object-position: left;" src="{{ $base_url.$productRelate->feature_image_path }}" alt="{{ $productRelate->feature_image_name }}" />
															<h2>{{ number_format($productRelate->price, 0 ,',','.') }}đ</h2>
															<p>{{ Str::words($productRelate->name,6) }}</p>
														</a>
														{{-- <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button> --}}
														<div style="display: flex;">
															<a data-url="{{ route('add_to_cart.index', ['id' => $productRelate->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a>
															<a data-product_id="{{ $productRelate->id }}" data-slug="{{ $productRelate->slug }}" class="btn btn-default quickview-product" data-toggle="modal" data-target="#quickview"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning" viewBox="0 0 16 16">
																<path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641l2.5-8.5zM6.374 1 4.168 8.5H7.5a.5.5 0 0 1 .478.647L6.78 13.04 11.478 7H8a.5.5 0 0 1-.474-.658L9.306 1H6.374z"/>
																</svg>Xem nhanh
															</a>
														</div>														
													</div>
												</div>
											</div>
										</div>
									@if ($keyProductRelate%3 == 2)
										</div>
									@endif
									@break($keyProductRelate == 3)			
								@endforeach								
							@endif
							</div>
	
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div>
	</section>  

	@include('DetailProduct/comment/modelLogin')
	@include('home.components.quickview_modal')
@endsection


@section('js')
	<script src="{{ asset('vendors/lightslider/lightgallery-all.min.js') }}"></script>
	<script src="{{ asset('vendors/lightslider/lightslider.js') }}"></script>
	<script src="{{ asset('vendors/sweetalert2/sweetalert2@11.js') }}"></script>

	<script src="{{ asset('FrontEnd/detailProduct/rating_star/rating_star.js') }}"></script>
	<script src="{{ asset('vendors/rating_star/rateyo.min.js') }}"></script>

	<script src="{{ asset('FrontEnd/detailProduct/comment/comment.js') }}"></script>
	<script src="{{ asset('FrontEnd/detailProduct/comment/index.js') }}"></script>

	<script src="{{ asset('FrontEnd/detailProduct/quickview/index.js') }}"></script>
	<script src="{{ asset('FrontEnd/Card/add/add_to_card.js') }}"></script>

	<script src="{{ asset('FrontEnd/detailProduct/productWatched/productWatched.js') }}"></script>

	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		function add_to_cart_detail(e){
			e.preventDefault();
			var url = $(this).attr('data-url');
			var quantity = $(this).parents('.product-information').find('#quantity').val();
			$.ajax({
				type: "post",
				url: url,
				data: {quantity:quantity},
				success: function (response) {
					if(response.status == 200){
						$('.cartt').html(response.numberCart);
						Swal.fire({
							position: 'center-center',
							icon: 'success',
							title: 'Đã thêm vào giỏ hàng',
							showConfirmButton: false,
							timer: 1400
						})
					}else{
						Swal.fire({
							position: 'center-center',
							icon: 'warning',
							title: 'Sản phẩm đã hết hàng',
							showConfirmButton: false,
							timer: 1400
						})
					}
				}
			});
		};
		$(document).on('click', '.add-to-cart-detail', add_to_cart_detail);
	</script>

	<script>
		$(document).ready(function() {
			$('#imageGallery').lightSlider({
				gallery:true,
				item:1,
				loop:true,
				thumbItem:3,
				slideMargin:0,
				enableDrag: true,
				currentPagerPosition:'left',
				onSliderLoad: function(el) {
					el.lightGallery({
						selector: '#imageGallery .lslide'
					});
				}   
			});  
		});
	</script>
@endsection


