@php
	// $base_url = 'http://localhost:8000/';
	$base_url = config('base_url.url_backend.url');
	// dd($base_url);
@endphp
@extends('layouts.master')

@section('title', 'Shop | P-Shopper')

@section('content')
	<section id="advertisement">
		<div class="container">
			{{-- <img src="/eshopper/images/shop/advertisement.jpg" alt="" /> --}}
			<img src="/eshopper/images/shop/800-200-800x200-194.png" alt="" />
		</div>
	</section>
	
	<section>
		<div class="container">
			<div class="row">
				@include('home.components.sidebar')
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">{{ $category->name }}</h2>
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
						<div class="clearfix">...</div>
						{{-- <ul class="pagination">
							<li class="active"><a href="">1</a></li>
							<li><a href="">2</a></li>
							<li><a href="">3</a></li>
							<li><a href="">&raquo;</a></li>
							{{ $products->links() }}
						</ul> --}}
						<div class="paginate_html paginate_price_range_html" data-price_min="" data-price_max="" style="display: grid;">
							{{-- @include('components.paginate') --}}
							{{ $products->links() }}
						</div>

					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>

	@include('home.components.quickview_modal')
	@include('compareProduct.compareProduct')

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
	{{-- <script src="{{ asset('FrontEnd/product/price_range.js') }}"></script> --}}
@endsection


