@extends('layouts.master')

@section('title', 'Home | P-Shopper')

@section('css')
	<style>
		.add-to-cart:hover {
			background: #5bc0de;
		}
		.productinfo h2 {
			color: #5bc0de;
		}
	</style>
@endsection

@section('content')
    @include('home.components.slider')
	<section>
		<div class="container">
			<div class="row">
                @include('home.components.sidebar')
				
				<div class="col-sm-9 padding-right">
                    {{-- product new --}}
                    @include('home.components.productNew')
					{{-- product category-tab --}}
					@include('home.components.productCategoryTag')
					{{-- product hot --}}
                    @include('home.components.productHot')
				</div>
			</div>
		</div>
	</section>

@include('home.components.quickview_modal')
@include('compareProduct.compareProduct')

@endsection

@section('js')
	<script src="{{ asset('FrontEnd/detailProduct/quickview/index.js') }}"></script>
	<script src="{{ asset('FrontEnd/Card/add/add_to_card.js') }}"></script>
	<script src="{{ asset('FrontEnd/product/loadMoreProductHome.js') }}"></script>

<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
</script>
@endsection