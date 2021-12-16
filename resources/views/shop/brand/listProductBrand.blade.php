@php
	$base_url = config('base_url.url_backend.url');
@endphp
@extends('layouts.master')

@section('title', 'Shop | P-Shopper')

@section('content')
	<section id="advertisement">
		<div class="container">
			<img src="/eshopper/images/shop/advertisement.jpg" alt="" />
		</div>
	</section>
	
	<section>
		<div class="container">
			<div class="row">
				@include('home.components.sidebar')
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">{{ $brand->name }}</h2>
						<div class="row" style="padding-bottom: 10px; margin-right: 0px;">
							<div class="col-md-8">

							</div>
							<div class="col-md-4">
								<select class="custom-select custom-select-sm filter_product" style="padding-right: 15px;">
									<option selected value="0">-------------------- Lọc sản phẩm ----------------------</option>
									<option value="1">Giá từ thấp đến cao</option>
									<option value="2">Giá từ cao đến thấp</option>
									<option value="3">Sắp xếp theo tên từ a-z</option>
									<option value="4">Sắp xếp theo tên từ z-a</option>
								</select>
							</div>
						</div>
						<div id="data_product_category">
							@include('shop.category.components.data')
						</div>
						<img id="img-loading-content" src="{{ asset('eshopper\images\loding-gif\loading5.gif') }}" style="width: 200px;margin-left: auto; margin-right: auto; display: none;" alt="">
						{{-- @foreach ($products as $product)
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
										<a href="{{ route('ProductDetail', ['id' => $product->id, 'slug' => $product->slug]) }}">	
											<img src="{{ $base_url.$product->feature_image_path }}" alt="" />
											<h2>{{ number_format($product->price, 0, ',', '.') }}đ</h2>
											<p>{{ Str::words($product->name, 6) }}</p>
										</a>
											
											<div style="display: flex;">
												<a data-url="{{ route('add_to_cart.index', ['id' => $product->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a>
												<a data-product_id="{{ $product->id }}" data-slug="{{ $product->slug }}" class="btn btn-default quickview-product" data-toggle="modal" data-target="#quickview"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning" viewBox="0 0 16 16">
													<path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641l2.5-8.5zM6.374 1 4.168 8.5H7.5a.5.5 0 0 1 .478.647L6.78 13.04 11.478 7H8a.5.5 0 0 1-.474-.658L9.306 1H6.374z"/>
													</svg>Xem nhanh
												</a>
											</div>
										</div>
										<img src="{{date('Y-m-d') == $product->created_at->format('Y-m-d') ? '/eshopper/images/home/new.png' : '#'}}" class="new" alt="" />
									</div>
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href=""><i class="fa fa-plus-square"></i>Yêu thích</a></li>
											<li><a href=""><i class="fa fa-plus-square"></i>So sánh</a></li>
										</ul>
									</div>
								</div>
							</div>
						@endforeach --}}
						<div class="clearfix">...</div>
						{{-- <ul class="pagination">
							<li class="active"><a href="">1</a></li>
							<li><a href="">2</a></li>
							<li><a href="">3</a></li>
							<li><a href="">&raquo;</a></li>
							{{ $products->links() }}
						</ul> --}}
						<div class="paginate_html" style="display: grid;">
							{{-- @include('components.paginate') --}}
							{{ $products->links() }}
						</div>
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
	
	@include('home.components.quickview_modal')
@endsection

@section('js')
	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
	<script src="{{ asset('FrontEnd/detailProduct/quickview/index.js') }}"></script>
	<script src="{{ asset('FrontEnd/Card/add/add_to_card.js') }}"></script>
	<script src="{{ asset('FrontEnd/product/filter.js') }}"></script>
@endsection

