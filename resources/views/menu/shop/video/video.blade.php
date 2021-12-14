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
						<h2 class="title text-center">Video</h2>
						@foreach ($videos as $video)
							<div class="col-sm-4">
								<div class="video-image-wrapper">
									<div class="single-videos">
										<div class="videoinfo text-center">
										<a>	
											<img style="width: 200px;height: auto;" src="{{ $base_url.$video->image_path_video }}" alt="" />
											{{-- <h2>{{ number_format($video->price, 0, ',', '.') }}đ</h2> --}}
											<p>{{ $video->title }}</p>
										</a>
											<a data-url="video/{{ $video->slug }}" data-id="{{ $video->id }}" class="btn btn-default playVideo" data-toggle="modal" data-target="#exampleModalCenter"><svg style="margin-right: 5px" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-btn" viewBox="0 0 16 16">
                                                <path d="M6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814l-3.5-2.5z"/>
                                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                                </svg>Xem video
                                            </a>
										</div>
										<img src="{{date('Y-m-d') == $video->created_at->format('Y-m-d') ? '/eshopper/images/home/new.png' : '#'}}" class="new" alt="" />
									</div>
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href=""><i class="fa fa-plus-square"></i>Yêu thích</a></li>
											{{-- <li><a href=""><i class="fa fa-plus-square"></i>So sánh</a></li> --}}
										</ul>
									</div>
								</div>
							</div>
						@endforeach
					
						<ul class="pagination">
							{{-- <li class="active"><a href="">1</a></li>
							<li><a href="">2</a></li>
							<li><a href="">3</a></li>
							<li><a href="">&raquo;</a></li> --}}
							{{ $videos->links() }}
						</ul>
						
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
@include('menu.shop.video.playVideoModal')

@endsection
@section('js')
<Script>
    function playVideo(){
        var url = $(this).attr('data-url');
        var id = $(this).attr('data-id');
        $.ajax({
            type: "get",
            url: url,
            data: {id: id},
            success: function (response) {
                if(response.status == 200){
					$('#titleVideo').text(response.video.title);
					$('#discriptionVideo').text(response.video.discription);
					$('#linkVideo').attr('src', 'https://www.youtube.com/embed/'+response.video.link.substr(17));
				}
            }
        });
    }
	function ClosePlayVideo(){
					$('#titleVideo').text('');
					$('#discriptionVideo').text('');
					$('#linkVideo').attr('src', '');
	}

    $(document).on('click', '.playVideo', playVideo);
    $(document).on('click', '.CloseVideo', ClosePlayVideo);
</Script>
@endsection



