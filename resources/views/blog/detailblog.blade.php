<?php
$base_url = 'http://localhost:8000/';
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
                        {{-- <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordian" href="#sportswear">
                                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                        Sportswear
                                    </a>
                                </h4>
                            </div>
                            <div id="sportswear" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li><a href="">Nike </a></li>
                                        <li><a href="">Under Armour </a></li>
                                        <li><a href="">Adidas </a></li>
                                        <li><a href="">Puma</a></li>
                                        <li><a href="">ASICS </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                        @foreach ($categoryPosts as $categoryPost)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="{{ route('blog.show', ['id' => $categoryPost->id, 'slug' => $categoryPost->slug]) }}">{{ $categoryPost->name }}</a></h4>
                                </div>
                            </div>
                        @endforeach
                    </div><!--/category-products-->
            
                    
                    <div class="shipping text-center"><!--shipping-->
                        <img src="images/home/shipping.jpg" alt="" />
                    </div><!--/shipping-->
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
							<li>
								<i class="fa fa-star color"></i>
								<i class="fa fa-star color"></i>
								<i class="fa fa-star color"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</li>
							<li class="color">(6 votes)</li>
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
						<a class="pull-left" href="#">
							<img class="media-object" src="images/blog/man-one.jpg" alt="">
						</a>
						<div class="media-body">
							<h4 class="media-heading">Annie Davis</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
							<div class="blog-socials">
								<ul>
									<li><a href=""><i class="fa fa-facebook"></i></a></li>
									<li><a href=""><i class="fa fa-twitter"></i></a></li>
									<li><a href=""><i class="fa fa-dribbble"></i></a></li>
									<li><a href=""><i class="fa fa-google-plus"></i></a></li>
								</ul>
								<a class="btn btn-primary" href="">Other Posts</a>
							</div>
						</div>
					</div><!--Comments-->
					<div class="response-area">
						<h2>3 RESPONSES</h2>
						<ul class="media-list">
							<li class="media">
								
								<a class="pull-left" href="#">
									<img class="media-object" src="images/blog/man-two.jpg" alt="">
								</a>
								<div class="media-body">
									<ul class="sinlge-post-meta">
										<li><i class="fa fa-user"></i>Janis Gallagher</li>
										<li><i class="fa fa-clock-o"></i> 1:33 pm</li>
										<li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
									</ul>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>
								</div>
							</li>
							<li class="media second-media">
								<a class="pull-left" href="#">
									<img class="media-object" src="images/blog/man-three.jpg" alt="">
								</a>
								<div class="media-body">
									<ul class="sinlge-post-meta">
										<li><i class="fa fa-user"></i>Janis Gallagher</li>
										<li><i class="fa fa-clock-o"></i> 1:33 pm</li>
										<li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
									</ul>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>
								</div>
							</li>
							<li class="media">
								<a class="pull-left" href="#">
									<img class="media-object" src="images/blog/man-four.jpg" alt="">
								</a>
								<div class="media-body">
									<ul class="sinlge-post-meta">
										<li><i class="fa fa-user"></i>Janis Gallagher</li>
										<li><i class="fa fa-clock-o"></i> 1:33 pm</li>
										<li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
									</ul>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									<a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>
								</div>
							</li>
						</ul>					
					</div><!--/Response-area-->
					<div class="replay-box">
						<div class="row">
							<div class="col-sm-4">
								<h2>Leave a replay</h2>
								<form>
									<div class="blank-arrow">
										<label>Your Name</label>
									</div>
									<span>*</span>
									<input type="text" placeholder="write your name...">
									<div class="blank-arrow">
										<label>Email Address</label>
									</div>
									<span>*</span>
									<input type="email" placeholder="your email address...">
									<div class="blank-arrow">
										<label>Web Site</label>
									</div>
									<input type="email" placeholder="current city...">
								</form>
							</div>
							<div class="col-sm-8">
								<div class="text-area">
									<div class="blank-arrow">
										<label>Your Name</label>
									</div>
									<span>*</span>
									<textarea name="message" rows="11"></textarea>
									<a class="btn btn-primary" href="">post comment</a>
								</div>
							</div>
						</div>
					</div><!--/Repaly Box-->

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