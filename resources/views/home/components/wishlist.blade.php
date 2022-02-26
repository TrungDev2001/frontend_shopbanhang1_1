@php
	$base_url = config('base_url.url_backend.url');
@endphp
@extends('layouts.master')

@section('title', 'Website | Thương mại điện tử')

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Yêu thích</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="">Ảnh</td>
                        <td class="">Tên sản phẩm</td>
                        <td class="">Giá</td>
                        <td class="">Hoạt động</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="clear_wishlist"></div>
        </div>
    </div>
</section>
@endsection

@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
	<script src="{{ asset('FrontEnd/Card/add/add_to_card.js') }}"></script>
	<script src="{{ asset('FrontEnd/header/wishlist/getWishlist.js') }}"></script>
@endsection


