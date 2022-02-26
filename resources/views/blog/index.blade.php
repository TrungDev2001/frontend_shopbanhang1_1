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
                    <h2 class="title text-center">Bài viết mới nhất</h2>
                    @foreach ($posts as $post)
                        <div class="single-blog-post">
                            <h3>{{ $post->title }}</h3>
                            <div class="post-meta">
                                <ul>
                                    <li><i class="fa fa-user"></i> {{ $post->users->name }}</li>
                                    <li><i class="fa fa-clock-o"></i> {{ date_format($post->created_at, "H : i") }}</li>
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
                            <div>
                                <a href="{{ route('blog.detail', ['id' => $post->id, 'slug' => $post->slug]) }}" style="float: left;">
                                    <img src="{{ $base_url.$post->image_path }}" alt="{{ $post->image_name }}">
                                </a>
                                <div>
                                    <p class="">{{ $post->description }}</p>
                                    <a  class="btn btn-primary" href="{{ route('blog.detail', ['id' => $post->id, 'slug' => $post->slug]) }}">Đọc thêm</a>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    @endforeach
                    <div class="pagination-area">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection






