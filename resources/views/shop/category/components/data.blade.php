@php
	$base_url = config('base_url.url_backend.url');
@endphp
@foreach ($products as $product)
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                <a href="{{ route('ProductDetail', ['id' => $product->id, 'slug' => $product->slug]) }}">	
                    <img src="{{ $base_url.$product->feature_image_path }}" alt="" />
                    @if ($product->promotional_price != 0)
                        <div>
                            <p style="display: inline-block; padding-right: 5px;     text-decoration-line: line-through;">{{ number_format($product->price, 0, ',', '.') }}đ</p><span>-{{ round(($product->price - $product->promotional_price) / $product->price * 100) }}%</span>
                        </div>
                        <h2 style="margin-top: 0px;">{{ number_format($product->promotional_price, 0, ',', '.') }}đ</h2>
                    @else
                        <h2 style="margin-top: 30px;">{{ number_format($product->price, 0, ',', '.') }}đ</h2>
                    @endif
                    <p>{{ Str::words($product->name, 6) }}</p>
                </a>
                    {{-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a> --}}
            <div style="display: flex;">
                <a data-url="{{ route('add_to_cart.index', ['id' => $product->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a>
                <a data-product_id="{{ $product->id }}" data-slug="{{ $product->slug }}" class="btn btn-default quickview-product" data-toggle="modal" data-target="#quickview"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning" viewBox="0 0 16 16">
                    <path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641l2.5-8.5zM6.374 1 4.168 8.5H7.5a.5.5 0 0 1 .478.647L6.78 13.04 11.478 7H8a.5.5 0 0 1-.474-.658L9.306 1H6.374z"/>
                    </svg>Xem nhanh
                </a>
            </div>

                </div>
                <img src="{{date('Y-m-d') == $product->created_at->format('Y-m-d') ? '/eshopper/images/home/new.png' : '#'}}" class="new" alt="" />
                <img src="{{$product->promotional_price != 0 ? '/eshopper/images/home/sale.png' : '#'}}" class="sale" alt="" />
            </div>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a class="btn-add-wishlist compareProduct_{{ $product->id }}" 
                            data-product_id="{{ $product->id }}"
                            data-product_name="{{ Str::words($product->name, 9) }}"
                            data-product_price="{{ number_format($product->price, 0, ',', '.') }}"
                            data-feature_image_path="{{ $base_url.$product->feature_image_path }}"
                            data-url_DetailProduct="{{ route('ProductDetail', ['id' => $product->id, 'slug' => $product->slug]) }}"
                            data-url_addToCard="{{ route('add_to_cart.index', ['id' => $product->id])}}"
                            ><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                    <li><a href="" data-product_id="{{ $product->id }}" class="compareProduct" data-toggle="modal" data-target=".compareProduct1"><i class="fa fa-plus-square"></i>So sánh</a></li>
                </ul>
            </div>
        </div>
    </div>
@endforeach