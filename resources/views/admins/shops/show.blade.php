@extends('admins.adminLte')

@section('styles')
    <style>
        .height {
            height: 119px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card p-4">
                <div class="row justify-content-between">
                    <div class="col">
                        <h3> Shop's Details </h3>
                    </div>
                    <div class="col-1">
                        <a href="{{ route('admins.shops.index') }}">
                            <div class="btn btn-close float-end" aria-label="Close">
                            </div>
                        </a>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row mt-4">
                    <div class="col-4"> 
                        <label for="name" > Shop Name: </label>
                    </div>
                    <div class="col-8"> 
                        <input type="text" id="name" value="{{ $shop->name }}" disabled class="form-control"> 
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4"> 
                        <label for="ph-number" > Ph Number: </label> 
                    </div>
                    <div class="col-8"> 
                        <input type="text" id="ph_number" value="{{ $shop->ph_number }}" disabled class="form-control">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-4"> 
                        <label for="email" > Email Address: </label>
                    </div>
                    <div class="col-8"> 
                        <input type="text" id="email" value="{{ $shop->user->email }}" disabled class="form-control"> 
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4"> 
                        <label for="address" > Shop Address: </label> 
                    </div>
                    <div class="col-8"> 
                        <input type="text" id="address" value="{{ $shop->shop_address }}" disabled class="form-control">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-4"> 
                        <label for="owner_name" > Owner Name: </label>
                    </div>
                    <div class="col-8"> 
                        <input type="text" id="owner_name" value="{{ $shop->user->name }}" disabled class="form-control"> 
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4"> 
                        <label for="menus" > Menu Types: </label> 
                    </div>
                    <div class="col-8"> 
                        @foreach($shop->menu_types as $menu)
                        <button class="btn btn-secondary" disabled>
                            {{ $menu->name }}
                        </button>
                        @endforeach
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4"> 
                        <label for="images" > Featured Photos: </label> 
                    </div>
                    <div class="col-8">
                        <div class="row">
                            @foreach($shop->images as $image)
                                <div class="col-2">
                                    <img src="{{ asset($image->path) }}" class="w-100 height">
                                </div> 
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-4">
                        <label for="actions" > </label>
                    </div>
                    <div class="col-8">
                        <a href="{{ route('admins.shops.approve', $shop->id) }}">
                            <div class="col-2 btn btn-success">
                                <i class="fa-solid fa-circle-check"></i> Approve
                            </div>
                        </a>
                        <a href="{{ route('admins.shops.reject', $shop->id) }}">
                            <div class="col-2 btn btn-danger">
                                <i class="fa-solid fa-circle-xmark"></i> Reject
                            </div>
                        </a>
                    </div>        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection