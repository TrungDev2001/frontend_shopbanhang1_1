<?php
	$base_url = config('base_url.url_backend.url');
	// $base_url = 'http://localhost:8000/';
?>
<section id="slider"><!--slider-->
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div id="slider-carousel" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						@foreach ($sliders as  $keySlider => $slider)
							<li data-target="#slider-carousel" data-slide-to="{{$keySlider}}" class=" {{ $keySlider == 0 ? 'active' : '' }}"></li>							
						@endforeach
					</ol>
					<div class="carousel-inner">
						@foreach ($sliders as  $keySlider => $slider)
							<div class="item {{ $keySlider == 0 ? 'active' : '' }}">
							{{-- <div class="col-sm-6">
								<h1><span>P</span>-SHOPPING</h1>
								<h2>{{$slider->name}}</h2>
								<p>{{$slider->description}}</p>
								<button type="button" class="btn btn-default get">Get it now</button>
							</div> --}}

							{{-- <style>
								.carousel-inner {
									background-image: url({{$base_url.$slider->image_path_Sider}});
								}
							</style> --}}
							<div class="col-sm-10">
								<img src="{{$base_url.$slider->image_path_Sider}}" style="width: max-content" class="girl img-responsive" alt="" />
							</div>
						</div>	
						@endforeach
					</div>
					
					<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
						<i class="fa fa-angle-left"></i>
					</a>
					<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
						<i class="fa fa-angle-right"></i>
					</a>
				</div>
				
			</div>
		</div>
	</div>
</section><!--/slider-->