@php
	$base_url = 'http://localhost:8000/';
@endphp
<div class="col-sm-3">
	<div class="left-sidebar">
		<h2>Danh mục</h2>
		<div class="panel-group category-products" id="accordian"><!--category-productsr-->
			@foreach ($categories as $category)
				@if ($category->categoryChildren->count())
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordian" href="#{{ $category->slug }}">
									<span class="badge pull-right"><i class="{{ $category->categoryChildren->count() ? 'fa fa-plus' : ''}}"></i></span>
									{{ $category->name }}
								</a>
							</h4>
						</div>
						<div id="{{ $category->slug }}" class="panel-collapse collapse">
							<div class="panel-body">
								<ul>
									@foreach ($category->categoryChildren as $cChildren)
										<li><a href="{{ route('categoryProduct.shop', ['slug' => $cChildren->slug, 'id' => $cChildren->id]) }}">{{ $cChildren->name }}</a></li>							
									@endforeach
								</ul>
							</div>
						</div>
					</div>	
				@else
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a href="{{ route('categoryProduct.shop', ['slug' => $category->slug, 'id' => $category->id]) }}">
									<span class="badge pull-right"></span>
									{{ $category->name }}
								</a>
							</h4>
						</div>
					</div>						
				@endif			
			@endforeach

		</div><!--/category-products-->
	
		<div class="brands_products"><!--brands_products-->
			<h2>Thương hiệu</h2>
			<div class="brands-name">
				<ul class="nav nav-pills nav-stacked">
					@foreach ($brands as $brand)
						<li><a href="{{ route('brandProduct.shop', ['id' => $brand->id]) }}"> <span class="pull-right">({{ $brand->BrandProducts->count() }})</span>{{ $brand->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div><!--/brands_products-->

	@if (isset($products))	
		<div class="price-range"><!--price-range-->
			<h2>Price Range</h2>
			<div class="well text-center">
					<input type="text" class="span2" value="" data-slider-min="0" data-slider-max="{{ round( $products->max('price') - ($products->max('price')%1000000) ) + 10000000 }}" data-slider-step="100000" data-slider-value="[{{$products->min('price')}},{{$products->max('price')}}]" id="sl2" ><br />
					<b class="pull-left"> 0 đ</b> <b class="pull-right"> {{ number_format(round( $products->max('price') - ($products->max('price')%1000000) ) + 10000000 ) }} đ</b>					
			</div>
		</div><!--/price-range-->
	@endif
		
		<div class="shipping text-center"><!--shipping-->
			<img src="{{ $base_url.$ads->path_image_ads }}" alt="{{ $ads->name_image_ads }}" />
		</div><!--/shipping-->
	
	</div>
</div>