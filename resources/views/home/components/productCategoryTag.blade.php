@php
	$base_url = config('base_url.url_backend.url');
@endphp
<div class="category-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            @foreach ($categories as $keyCategory => $category)
                <li class="{{ $keyCategory == 0 ? 'active' : '' }}"><a href="#{{$category->slug}}" data-toggle="tab">{{$category->name}}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="tab-content">
        @foreach ($categories as $keyCP => $categoryP)
            <div class="tab-pane fade {{ $keyCP == 0 ? 'active in' : ''}}" id="{{$categoryP->slug}}" >
                @foreach ($categoryP->Products->sortDesc()->take(4) as $categoryProduct)
                    <div class="col-sm-3">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <a href="{{ route('ProductDetail', ['id' => $categoryProduct->id, 'slug' => $categoryProduct->slug]) }}">
                                        <img class="productTag" src="{{$base_url.$categoryProduct->feature_image_path}}" alt="{{$categoryProduct->feature_image_name}}" />
                                        <h2>{{ number_format($categoryProduct->price,0,',','.') }}đ</h2>
                                        <p>{{$categoryProduct->name}}</p>
                                    </a>                                    
                                    <a data-url="{{ route('add_to_cart.index', ['id' => $categoryProduct->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                                </div>
                                <img src="{{date('Y-m-d') == $categoryProduct->created_at->format('Y-m-d') ? '/eshopper/images/home/new.png' : '#'}}" class="new" alt="" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

    </div>
</div><!--/category-tab-->