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
                <li class="active">Đơn hàng</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="">Mã đơn hàng</td>
                        <td class="">Thành tiền</td>
                        <td class="">Thanh toán</td>
                        <td class="">Ngày đặt hàng</td>
                        <td class="">Trạng thái</td>
                        <td class=""></td>
                    </tr>
                </thead>
                <tbody>
                    @if ($oders->total()==0)
                        <tr>
                            <td colspan="6" align="center">Bạn chưa mua sản phẩm nào</td>
                        </tr>
                    @endif
                    @foreach ($oders as $oder)
                        @php
                            $priceVoucher = 0;
                            if($oder->coupon_id != 0){
                                $number = $oder->Voucher->number;
                                $numberMax = $oder->Voucher->numberMax;
                                if($oder->Voucher->type == 0){
                                    if($numberMax > 0){
                                        $priceVoucher = $numberMax;
                                    }else{
                                        $priceVoucher = $oder->total_price * $number / 100;
                                    }
                                }else {
                                    $priceVoucher = $oder->Voucher->number;
                                }
                            }

                            if($oder->active == 0){
                                $active = 'Chờ xác nhận';
                            }elseif($oder->active == 1){
                                $active = 'Chờ lấy hàng';
                            }elseif($oder->active == 2){
                                $active = 'Đang giao';
                            }elseif($oder->active == 3){
                                $active = 'Đã giao';
                            }elseif($oder->active == 4){
                                $active = 'Đã hủy';
                            }elseif($oder->active == 5){
                                $active = 'Trả hàng';
                            }
                        @endphp
                        <tr>
                            <td>{{ $oder->id }}</td>
                            <td>{{ number_format($oder->total_price+$oder->priceShip-$priceVoucher, 0, ',', '.') }}đ</td>
                            <td>{{ $oder->payment }}</td>
                            <td>{{ $oder->created_at->format('d-m-Y')}}</td>
                            <td>{{ $active }}</td>
                            <td>
                                <a href="{{ route('home.header.show_bought', ['id' => $oder->id]) }}"><button class="btn btn-info">Chi tiết</button></a>
                                <span><button data-url="{{ route('home.header.delete_bought', ['id' => $oder->id])}}" class="btn btn-danger delete-sweetalert">Hủy mua</button></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                        <div class="paginate_html paginate_price_range_html" data-price_min="" data-price_max="" style="display: grid;">
							{{-- @include('components.paginate') --}}
							{{ $oders->links() }}
						</div>
            <div class="clear_wishlist"></div>
        </div>
    </div>
</section>
@endsection

@section('js')
    <script src="{{ asset('vendors/deleteAjaxSweetalert.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
	{{-- <script src="{{ asset('FrontEnd/Card/add/add_to_card.js') }}"></script>
	<script src="{{ asset('FrontEnd/header/wishlist/getWishlist.js') }}"></script> --}}
@endsection


