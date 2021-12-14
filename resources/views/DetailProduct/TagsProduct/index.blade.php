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
						<h2 class="title text-center">{{ $tag_name }}</h2>
							<div class="row" style="padding-bottom: 10px; margin-right: 0px;">
								<div class="col-md-8">

								</div>
								<div class="col-md-4">
									{{-- <input type="hidden" id="category_id" value="{{ $brand->id }}" name="">
									<input type="hidden" id="category_slug" value="{{ $brand->slug }}" name=""> --}}
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
										<a href="{{ route('ProductDetail', ['id' => $product->id, 'slug' => $product->id]) }}">	
											<img src="{{ $base_url.$product->feature_image_path }}" alt="" />
											<h2>{{ number_format($product->price, 0, ',', '.') }}đ</h2>
											<p>{{ $product->name }}</p>
										</a>
											<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
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
							@include('components.paginate')
						</div>
											
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
@endsection

@section('js')
	<script src="{{ asset('FrontEnd/product/filter.js') }}"></script>
@endsection



