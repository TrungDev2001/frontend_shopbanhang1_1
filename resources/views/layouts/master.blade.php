<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        @yield('ShareFB')
        <link href="{{asset('eshopper/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('eshopper/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{asset('eshopper/css/prettyPhoto.css')}}" rel="stylesheet">
        <link href="{{asset('eshopper/css/price-range.css')}}" rel="stylesheet">
        <link href="{{asset('eshopper/css/animate.css')}}" rel="stylesheet">
        <link href="{{asset('eshopper/css/main.css')}}" rel="stylesheet">
        <link href="{{asset('eshopper/css/responsive.css')}}" rel="stylesheet">
        <link rel="shortcut icon" href="{{asset('eshopper/images/home/logo1.png')}}">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('eshopper/images/ico/apple-touch-icon-144-precomposed.png')}}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('eshopper/images/ico/apple-touch-icon-114-precomposed.png')}}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('eshopper/images/ico/apple-touch-icon-72-precomposed.png')}}">
        <link rel="apple-touch-icon-precomposed" href="{{asset('eshopper/images/ico/apple-touch-icon-57-precomposed.png')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
        <link rel="stylesheet" href="sweetalert2.min.css">
        @yield('css')
    </head>
    <body>
        @include('components.header')

        @yield('content')

        @include('components.footer')
        <script src="{{asset('eshopper/js/jquery.js')}}"></script>
        <script src="{{asset('eshopper/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('eshopper/js/jquery.scrollUp.min.js')}}"></script>
        <script src="{{asset('eshopper/js/price-range.js')}}"></script>
        <script src="{{asset('eshopper/js/jquery.prettyPhoto.js')}}"></script>
        <script src="{{asset('eshopper/js/main.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="{{ asset('FrontEnd/header/search/search.js') }}"></script>

        <script src="{{ asset('FrontEnd/product/add_wishlist.blade.js') }}"></script> {{-- sản phẩm yêu thích--}}
        <script src="{{ asset('FrontEnd/detailProduct/productWatched/productWatched.js') }}"></script> {{-- sản phẩm đã xem --}}
        <script src="{{ asset('FrontEnd/product/compareProduct.js') }}"></script> {{-- so sánh sản phẩm --}}
        
        @yield('js')

        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0&appId=462467081650498&autoLogAppEvents=1" nonce="qoDR9Hlo"></script>

        {{-- zalo --}}
        <div class="zalo-chat-widget" data-oaid="600375768305189490" data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="1" data-width="350" data-height="420"></div>
        <script src="https://sp.zalo.me/plugins/sdk.js"></script>
    </body>
</html>