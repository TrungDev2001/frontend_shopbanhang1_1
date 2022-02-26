<?php
	$base_url = config('base_url.url_backend.url');
$totalPrice = 0;
?>
@extends('layouts.master')

@section('title', 'Cart | P-Shopper')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Danh mục bài viết</h2>
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        @foreach ($categoryPosts as $categoryPost)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="{{ route('blog.show', ['id' => $categoryPost->id, 'slug' => $categoryPost->slug]) }}">{{ $categoryPost->name }}</a></h4>
                                </div>
                            </div>
                        @endforeach
                    </div><!--/category-products-->
            
                    
                    {{-- <div class="shipping text-center"><!--shipping-->
                        <img src="images/home/shipping.jpg" alt="" />
                    </div><!--/shipping--> --}}
                </div>
            </div>
				<div class="col-sm-9">
					<div class="blog-post-area">
						<h2 class="title text-center">{{ $post->title }}</h2>
						<div class="single-blog-post">
							<h3>{{ $post->description }}</h3>
							<div class="post-meta">
								<ul>
									<li><i class="fa fa-user"></i> {{ $PostUser->name }}</li>
									<li><i class="fa fa-clock-o"></i> {{ date_format($post->created_at, "H:i") }}</li>
									<li><i class="fa fa-calendar"></i> {{ date_format($post->created_at, "M d, Y") }}</li>
								</ul>
								<span>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-half-o"></i>
								</span>
							</div>
							<a href="">
								<img src="{{ $base_url.$post->image_path }}" alt="{{ $post->image_name }}">
							</a>
							<p>{!! $post->content !!}</p>
							<div class="pager-area">
								<ul class="pager pull-right">
									{{-- <li><a href="{{ redirect()->getUrlGenerator()->previous() }}">Quay về</a></li> --}}
									@if (count($categoryPostRelateds)>0)
										<li><a href="{{ redirect()->back()->getTargetUrl() }}">Quay về</a></li>
										@foreach ($categoryPostRelateds as $categoryPostRelated)
											
										@endforeach
										<li><a href="{{ route('blog.detail', ['id' => $categoryPostRelated->id, 'slug' => $categoryPostRelated->slug]) }}">Kế tiếp</a></li>								
									@endif
								</ul>
							</div>
						</div>
					</div><!--/blog-post-area-->

					<div class="rating-area">
						<ul class="ratings">
							<li class="rate-this">Đánh giá bài viết này:</li>
							{{-- <li>
								<i class="fa fa-star color"></i>
								<i class="fa fa-star color"></i>
								<i class="fa fa-star color"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</li>
							<li class="color">(6 votes)</li> --}}
						</ul>
						<ul class="tag">
							<li>TAG:</li>
                            @php
                                $numItems = count($post->tags);
                                $i = 0;
                            @endphp
                            @foreach ($post->tags as $key => $tag)
                                @if (++$i === $numItems - 1)
                                    <li><a class="color" href="{{ route('blog.tag', ['id' => $tag->id, 'tagName' => $tag->name]) }}">{{$tag->name}} <span>/</span></a></li> 
                                @else
                                    <li><a class="color" href="{{ route('blog.tag', ['id' => $tag->id, 'tagName' => $tag->name]) }}">{{$tag->name}}</a></li>
                                @endif                   
                            @endforeach
						</ul>
					</div><!--/rating-area-->

					<div class="socials-share">
						<a href=""><img src="public/eshopper/images/blog/socials.png" alt=""></a>
					</div><!--/socials-share-->

					<div class="media commnets">
						<div class="fb-comments" data-href="{{ route('blog.detail', ['id' => $post->id, 'slug' => $post->slug]) }}" data-width="700" data-numposts="5"></div>
					</div>
                </div>
				</div>

				@if (count($categoryPostRelateds)>0)
					<p class="text-center" style="font-size: 30px;">Các bài viết liên quan</p>
					<div style="display: flex; flex-wrap: nowrap; justify-content: space-around; flex-direction: row-reverse; align-items: center;">
							@foreach ($categoryPostRelateds as $categoryPostRelated)
								<a href="{{ route('blog.detail', ['id' => $categoryPostRelated->id, 'slug' => $categoryPostRelated->slug]) }}">
									<div style="flex-grow: 2.5">
										<img style="width: 255px;" src="{{ $base_url.$categoryPostRelated->image_path }}" alt="{{ $categoryPostRelated->image_name }}">
										<p style="color: black">{{ $categoryPostRelated->title }}</p>
									</div>
								</a>
							@endforeach
					</div>
				@endif
        </div>
    </div>
@endsection

@section('js')

@endsection