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
                @foreach ($categoryP->Products->where('active', 0)->sortDesc()->take(4) as $categoryProduct)
                    <div class="col-sm-3">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <a href="{{ route('ProductDetail', ['id' => $categoryProduct->id, 'slug' => $categoryProduct->slug]) }}">
                                        <img class="productTag" src="{{$base_url.$categoryProduct->feature_image_path}}" alt="{{$categoryProduct->feature_image_name}}" />
                                        {{-- <h2>{{ number_format($categoryProduct->price,0,',','.') }}đ</h2> --}}

                                        @if ($categoryProduct->promotional_price != 0)
                                            <div>
                                                <p style="display: inline-block; padding-right: 5px;     text-decoration-line: line-through;">{{ number_format($categoryProduct->price, 0, ',', '.') }}đ</p><span>-{{ round(($categoryProduct->price - $categoryProduct->promotional_price) / $categoryProduct->price * 100) }}%</span>
                                            </div>
                                            <h2 style="margin-top: 0px;">{{ number_format($categoryProduct->promotional_price, 0, ',', '.') }}đ</h2>
                                        @else
                                            <h2 style="margin-top: 30px;">{{ number_format($categoryProduct->price, 0, ',', '.') }}đ</h2>
                                        @endif

                                        <p>{{ Str::words($categoryProduct->name, 4) }}</p>
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