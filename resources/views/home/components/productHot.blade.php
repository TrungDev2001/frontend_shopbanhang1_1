@php
	$base_url = config('base_url.url_backend.url');
@endphp
<div class="recommended_items"><!--recommended_items-->
	<h2 class="title text-center">Sản phẩm hot</h2>
	
	<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			@foreach ($productHots as $keyproductHot => $productHot)
				@if ($keyproductHot % 3 == 0)
					<div class="item {{ $keyproductHot == 0 ? 'active' : '' }}">
				@endif
					<div class="col-sm-4">
						<div class="product-image-wrapper">
							<div class="single-products">
								<div class="productinfo text-center">
									<a href="{{ route('ProductDetail', ['id' => $productHot->id, 'slug' => $productHot->slug]) }}">
										<img class="ImageproductHot" src="{{ $base_url.$productHot->feature_image_path }}" style="width: 165px; height: 182px; object-fit: cover;" alt="{{ $productHot->feature_image_name }}" />
										@if ($productHot->promotional_price != 0)
                                            <div>
                                                <p style="display: inline-block; padding-right: 5px;     text-decoration-line: line-through;">{{ number_format($productHot->price, 0, ',', '.') }}đ</p><span>-{{ round(($productHot->price - $productHot->promotional_price) / $productHot->price * 100) }}%</span>
                                            </div>
                                            <h2 style="margin-top: 0px;">{{ number_format($productHot->promotional_price, 0, ',', '.') }}đ</h2>
                                        @else
                                            <h2 style="margin-top: 30px;">{{ number_format($productHot->price, 0, ',', '.') }}đ</h2>
                                        @endif
										<p>{{ Str::words($productHot->name, 6) }}</p>
									</a>
									{{-- <a data-url="{{ route('add_to_cart.index', ['id' => $productHot->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a> --}}
									<div style="display: flex;">
										<a data-url="{{ route('add_to_cart.index', ['id' => $productHot->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a>
										<a data-product_id="{{ $productHot->id }}" data-slug="{{ $productHot->slug }}" class="btn btn-default quickview-product" data-toggle="modal" data-target="#quickview"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning" viewBox="0 0 16 16">
											<path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641l2.5-8.5zM6.374 1 4.168 8.5H7.5a.5.5 0 0 1 .478.647L6.78 13.04 11.478 7H8a.5.5 0 0 1-.474-.658L9.306 1H6.374z"/>
											</svg>Xem nhanh
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				@if ($keyproductHot % 3 == 2)
					</div>
				@endif
			@endforeach

		</div>
			<a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
			<i class="fa fa-angle-left"></i>
			</a>
			<a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
			<i class="fa fa-angle-right"></i>
			</a>			
	</div>
</div><!--/recommended_items-->