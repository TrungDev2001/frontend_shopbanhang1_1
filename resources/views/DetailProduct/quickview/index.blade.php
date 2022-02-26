<?php
	$base_url = config('base_url.url_backend.url');
?>
@if (isset($productImages))
<div class="product-details"><!--product-details-->
    <div class="col-sm-6">
        <ul id="imageGallery">
                {{-- <li style="border: 0.5px solid #ffac30;" data-thumb="{{ $base_url.$product->feature_image_path }}" data-src="{{ $base_url.$product->feature_image_path }}">
                    <img style="border: 0.5px solid #ffac30;height: auto;max-width: 100%;" src="{{ $base_url.$product->feature_image_path }}" />
                </li> --}}
            @foreach ($productImages as $keyproductImage => $productImage)
                <li data-thumb="{{ $base_url.$productImage->product_ImagesDetail_path }}" data-src="{{ $base_url.$productImage->product_ImagesDetail_path }}">
                    <img style="height: auto;max-width: 100%;" src="{{ $base_url.$productImage->product_ImagesDetail_path }}" />
                </li>
            @endforeach
        </ul>

        {{-- <div class="view-product">
            <img src="{{ $base_url.$product->feature_image_path }}" alt="{{ $base_url.$product->feature_image_name }}" />
            <h3>ZOOM</h3>
        </div>

        <div id="similar-product" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    @foreach ($productImages as $keyproductImage => $productImage)
                        @if ($keyproductImage % 3 == 0)
                            <div class="item {{ $keyproductImage == 0 ? 'active' : '' }}">                                      
                        @endif
                            <a href=""><img src="{{ $base_url.$productImage->product_ImagesDetail_path }}" alt=""></a>
                        @if ($keyproductImage % 3 == 2)
                            </div>                                         
                        @endif
                    @endforeach
                </div>
                <!-- Controls -->
                @if ($productImages->count() > 3)
                <a class="left item-control" href="#similar-product" data-slide="prev">
                    <i class=" fa fa-angle-left"></i>
                </a>
                <a class="right item-control" href="#similar-product" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>                                
                @endif
        </div> --}}
    </div>

    <div class="col-sm-6"><!--/product-information-->
        <div class="product-information">
            <img src=" {{date('Y-m-d') == $product->created_at->format('Y-m-d') ? '/eshopper/images/product-details/new.jpg' : '#'}} " class="newarrival" alt="" />
            <h2>{{ $product->name }}</h2>
            <p>Mã: {{ $product->id }}</p>
            {{-- <img src="/eshopper/images/product-details/rating.png" alt="" /> --}}
            <div style="display: flex;">
                <div id="rateYo"></div>
                {{-- <div class="counter"></div>
                <input type="hidden" id="product_id" value="{{ $product->id }}">
                <input type="hidden" id="user_id" value="{{ Auth()->id() }}"> --}}
            </div>
            <span>
                @if ($product->promotional_price > 0)
                    <div style="display: flex;">
                        <p style="text-decoration-line: line-through;  margin-right: 10px;">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                        <p>-{{ round(($product->price - $product->promotional_price) / $product->price * 100) }}%</p>
                    </div>
                    <span>{{ number_format($product->promotional_price, 0, ',', '.') }}đ</span>
                @else
                    <span>{{ number_format($product->price, 0, ',', '.') }}đ</span>
                @endif

                
                <label>Số lượng:</label>
                <input id="quantity" type="number" min="1" value="1" />
                <a data-url="{{ route('add_to_cart.index', ['id' => $product->id])}}" class="btn btn-fefault cart add-to-cart-detail">
                    <i class="fa fa-shopping-cart"></i>
                    Thêm vào giỏ hàng
                </a>
            </span>
            <p><b>Mô tả:</b>{!! $product->description !!}</p>
            <p><b>Kho:</b> {{ $product->quantity_product != 0 ? 'Còn hàng' : 'Hết hàng' }}</p>
            <p><b>Tình trạng:</b> 
                @php
                    if($product->product_status == 0){
                        echo('Hàng mới');
                    }elseif ($product->product_status == 1) {
                        echo('Hàng đã qua sử dụng');
                    }elseif ($product->product_status == 2) {
                        echo('Hàng trưng bày');
                    }else{
                        echo('Hàng tồn kho');
                    }
                @endphp
            </p>
            <p><b>Thương hiệu:</b> {{ $productBrand->name }}</p>
            <fieldset>
                <legend>Tags:</legend>
                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16">
                    <path d="M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z"/>
                    <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z"/>
                    </svg>
                    @php
                        $countProductTag = count($product->tags);									
                    @endphp
                    @foreach ($product->tags as $key => $tag)
                        @if ($countProductTag == $key+1)
                            <a href="{{ route('product.tagProducts', ['slug' => str_replace(' ', '-', $tag->name)]) }}">{{ $tag->name }} max</a>
                        @else
                            <a href="{{ route('product.tagProducts', ['slug' => str_replace(' ', '-', $tag->name)]) }}">{{ $tag->name }}, </a>
                        @endif
                    @endforeach
                </p>
            </fieldset>
            <div style="display: inline-flex">
                <div class="fb-like" data-href="{{ $url_DetailProduct }}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="false"></div>
                <div class="fb-share-button" data-href="{{ $url_DetailProduct }}" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%3A8081%2Fproduct%2Fdetail%2F44&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
            </div>
            
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->
@endif
