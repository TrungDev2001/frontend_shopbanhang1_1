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
                <li class="active">Chi tiết đơn hàng</li>
            </ol>
        </div>


        <div class="info_KH_VC">
            <div>
                <h4>Thông tin khách hàng</h4>
                <p>Tên: {{ $user->name }}</p>
                <p>Email: {{ $user->email }}</p>
                <p>Phone: {{ $user->phone }}</p>
            </div>
            <div>
                <h4>Thông tin vận chuyển</h4>
                <p>Tên: {{ $oder->name }}</p>
                <p>Địa chỉ: {{ $oder->sonha }} - {{ $oder->XaPhuong->name }} - {{ $oder->QuanHuyen->name }} - {{ $oder->ThanhPho->name }}</p>
                <p>Số điện thoại: {{ $oder->phone }}</p>   
                <p>Ghi chú: {{ $oder->notes }}</p>   
            </div>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Mã Sp</th>
                    <th scope="col">Ảnh</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Tổng</th>
                </tr>
                <tbody id="dataOderDetail">
                    @foreach ($oderDetails as $key => $oderDetail)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $oderDetail->product_id }}</td>
                            <td><img width="100px" src="{{ $base_url.$oderDetail->image_path }}" alt="{{ $oderDetail->name }}"> </td>
                            <td>{{ $oderDetail->name }}</td>
                            <td>{{ $oderDetail->quantity }}</td>
                            <td>{{ number_format($oderDetail->price, 0, ',', '.') }}đ</td>
                            <td>{{ number_format($oderDetail->price*$oderDetail->quantity, 0, ',', '.') }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </thead>
        </table>
        
        @php
            $priceVoucher = 0;
            $nameVoucher = 'Không có';
            if($oder->coupon_id != 0){
                $number = $oder->Voucher->number;
                $numberMax = $oder->Voucher->numberMax;
                if($oder->Voucher->type == 0){
                    $nameVoucher = $oder->Voucher->name . ' "Mã giảm giá ' . $oder->Voucher->number . '% tối đa ' . number_format($oder->Voucher->numberMax, 0, ',', '.') . 'đ"';
                    if($numberMax > 0){
                        $priceVoucher = $numberMax;
                    }else{
                        $priceVoucher = $oder->total_price * $number / 100;
                    }
                }else {
                    $nameVoucher = $oder->Voucher->name . ' "Mã giảm giá ' . number_format($oder->Voucher->number, 0, ',', '.') . 'đ"';
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

        <div>
            <p>Tổng tiền hàng: {{ number_format($oder->total_price, 0, ',', '.') }}đ</p>
            <p>Tổng tiền mã giảm giá: {{ number_format($priceVoucher, 0, ',', '.') }}đ (<span>{{ $nameVoucher }}</span>)</p>
            <p>Phí vận chuyển: {{ number_format($oder->priceShip, 0, ',', '.') }}đ</p>
            <p>Thành tiền: {{ number_format($oder->total_price+$oder->priceShip-$priceVoucher, 0, ',', '.') }}đ</p>
        </div>
        <div style="margin-top: 15px; margin-bottom: 15px;">
            <b>Trạng thái đơn hàng: </b> <span>{{ $active }}</span>
        </div>
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
	{{-- <script src="{{ asset('FrontEnd/Card/add/add_to_card.js') }}"></script>
	<script src="{{ asset('FrontEnd/header/wishlist/getWishlist.js') }}"></script> --}}
@endsection


