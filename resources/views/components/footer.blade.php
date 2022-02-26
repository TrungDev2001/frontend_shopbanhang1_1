	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			{{-- <div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>e</span>-shopper</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('eshopper/images/home/iframe1.png') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('eshopper/images/home/iframe2.png') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('eshopper/images/home/iframe3.png') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('eshopper/images/home/iframe4.png') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="{{ asset('eshopper/images/home/map.png') }}" alt="" />
							<p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
						</div>
					</div>
				</div>
			</div> --}}
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Thông tin shop</h2>
							{!! $contact->info_shop !!}
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Liên kết</h2>
							<ul class="nav nav-pills nav-stacked">
								@foreach ($posts_footer as $post_footer)
									<li><a href="{{ route('blog.detail', ['id' => $post_footer->id, 'slug' => $post_footer->slug]) }}">{{ $post_footer->title }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Fanpage</h2>
							{!! $contact->fb_fanpage !!}
						</div>
					</div>
					<div class="col-sm-4">
						<div class="single-widget">
							<h2>Google Map</h2>
							<style>
								.ggmap_footer iframe{
									width: 330px;
									height: 140px;
								}
							</style>
							<div class="ggmap_footer">{!! $contact->ifream_ggmap !!}</div>
						</div>
					</div>
					{{-- <div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Your email address" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Get the most recent updates from <br />our site and be updated your self...</p>
							</form>
						</div>
					</div> --}}
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2022.</p>
					<p style="float: right;">
						<img class=" lazyloaded" src="//theme.hstatic.net/200000465365/1000820510/14/pay_copyright.png?v=98" data-src="//theme.hstatic.net/200000465365/1000820510/14/pay_copyright.png?v=98" width="247" height="25" alt="Payment">
					</p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->