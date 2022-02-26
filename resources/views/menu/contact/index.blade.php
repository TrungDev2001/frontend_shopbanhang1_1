@php
	$base_url = config('base_url.url_backend.url');
@endphp
@extends('layouts.master')

@section('title', 'Shop | P-Shopper')

@section('content')

    	 <div id="contact-page" class="container">
    	<div class="bg">
	    	<div class="row">    		
	    		<div class="col-sm-12">    			   			
					<h2 class="title text-center">Liên hệ với <strong>chúng tôi</strong></h2>    			    				    				
					<div id="gmap" class="contact-map">
                    	{{-- <div id="gmap" style=""> --}}
						{!! isset($contact) ? $contact->ifream_ggmap : '' !!}
					</div>
				</div>			 		
			</div>    	
    		<div class="row">  	
	    		<div class="col-sm-8">
	    			<div class="contact-form">
	    				<h2 class="title text-center">Liên lạc</h2>
						<h5 id="seccessContact" style="color: limegreen"></h5>
						@if (session()->has('seccessContact'))
							@php
								session()->forget('seccessContact')
							@endphp
							<script>
								document.getElementById("seccessContact").innerHTML = "Cảm ơn bạn đã liện hệ, chúng tôi sẽ liên hệ cho bạn trong thời gian sớm nhất có thể.";
							</script>
						@endif
	    				<div class="status alert alert-success" style="display: none"></div>
				    	<form action="{{ route('contact.store') }}" id="main-contact-form" class="contact-form row" name="contact-form" method="post">
							@csrf
				            <div class="form-group col-md-6">
				                <input type="text" name="name" class="form-control" required="required" placeholder="Name">
				            </div>
				            <div class="form-group col-md-6">
				                <input type="email" name="email" class="form-control" required="required" placeholder="Email">
				            </div>
				            <div class="form-group col-md-12">
				                <input type="text" name="subject" class="form-control" required="required" placeholder="Subject">
				            </div>
				            <div class="form-group col-md-12">
				                <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Your Message Here"></textarea>
				            </div>                        
				            <div class="form-group col-md-12">
				                <input type="submit" name="submit" class="btn btn-primary pull-right" value="Gửi">
				            </div>
				        </form>
	    			</div>
	    		</div>
	    		<div class="col-sm-4">
	    			<div class="contact-info">
	    				<h2 class="title text-center">Thông tin liên lạc</h2>
	    				<address>
							{!! isset($contact) ? $contact->info_shop : '' !!}
	    				</address>
	    				<div class="social-networks">
	    					<h2 class="title text-center">Mạng xã hội</h2>
							<ul>
								<li>
									<a target="_blank" href="{{ isset($contact) ? $contact->fb_link : '' }}"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a target="_blank" href="{{ isset($contact) ? $contact->twitter_link : '' }}"><i class="fa fa-twitter"></i></a>
								</li>
								{{-- <li>
									<a href="#"><i class="fa fa-google-plus"></i></a>
								</li> --}}
								<li>
									<a target="_blank" href="{{ isset($contact) ? $contact->youtube_link : '' }}"><i class="fa fa-youtube"></i></a>
								</li>
							</ul>
	    				</div>
	    			</div>
    			</div>    			
	    	</div>  
    	</div>	
    </div><!--/#contact-page-->

@endsection
@section('js')

@endsection



