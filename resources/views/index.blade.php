@extends('layouts.app')

@section('banner')
	<div class="banner">
		@if (session('success'))
			<div class="alert alert-success text-center" role="alert">
				{{ session('success') }}
			</div> 
		@endif
        <h1 class="col-lg-7 col-md-10">It's the food and groceries you love, delivered</h1>
    </div>
	@if(!Auth::check() || auth()->user()->status === "buyer")
	<div class="shop-register pt-5">
		<div class="shop-caption bg-white ms-5 px-5 py-4 shadow-larger">
			<p class="vendor-title"> List your restaurant or shop on delicious food </p>
			<p class="vendor-content text-muted" style="padding-top: 12px">
				Would you like millions of new customers to enjoy your amazing food and groceries? So would we!
				<span style="display: block; height: 12px"></span>
				It's simple: we list your menu and product lists online, help you process orders, pick them up,
				hungry pandas - in a heartbeat! 
				<span style="display: block; height: 12px"></span>
				and deliver them to hungry pandas – in a heartbeat!
			</p>
			<a href="{{ route('shops.register') }}" class="text-decoration-none text-white">
				<div class="get-started btn w-100 mt-2 p-2 fw-bold text-white">
					Get Started
				</div>
			</a>
		</div>
	</div>
	@endif
@endsection

@section('content')
	@include('shops.list')
@endsection
