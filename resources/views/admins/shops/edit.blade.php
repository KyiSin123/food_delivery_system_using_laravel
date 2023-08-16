@extends('admins.adminLte')

@section('styles')
    <style>
        .shop-register-btn {
            background-color: #fa5772;
        }
        .input-field {
            position: relative;
            margin-top: 2.2rem;
        }
        .multi-select-button:after {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-12 py-4">
            <div class="card p-5 shadow">
                <div class="row justify-content-between">
                    <div class="col">
                        <h2 class="create-post">Edit Shop's Info:</h2>
                    </div>
                    <div class="col-1">
                        <a href="{{ route('admins.shops.index') }}">
                            <div class="btn btn-close float-end" aria-label="Close">
                            </div>
                        </a>
                    </div>
                </div>                
                <form method="POST" action="{{ route('admins.shops.edit', $shop->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="my-3">
                        <label for="shop-name" class="form-label"> Restaurant/Shop Name: </label>
                        <input type="text" class="form-control @error('shop_name') is-invalid @enderror" id="shop-name" name="shop_name" 
                            value="{{ $shop->name }}">
                        @error('shop_name')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <label for="menus" class="form-label"> Select Types of Menu: </label>
                        <select id="menus" class="selectpicker @error('menus') is-invalid @enderror col-md-6" multiple
                            data-live-search="true" name="menus[]">
                            @foreach ($menus as $menu)
                                <option value="{{ $menu['id'] }}"
                                    {{ $shop->menu_types->contains($menu->id) ? 'selected' : '' }}>{{ $menu['name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('menus')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="owner-name" class="form-label"> Owner Name: </label>
                        <input type="text" class="form-control @error('owner_name') is-invalid @enderror" id="owner-name" name="owner_name"
                            value="{{ $shop->user->name }}">
                        @error('owner_name')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="contact-number" class="form-label"> Contact Number: </label>
                        <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact-number" placeholder="09123456789" name="contact_number"
                            value="{{ $shop->ph_number }}">
                        @error('contact_number')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"> Email address: </label>
                        <input type="email" class="form-control @error('shop_email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="example@gmail.com" name="shop_email"
                            value="{{ $shop->user->email }}">
                        @error('shop_email')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-field mb-4">
                        <label class="active">Update your menu photos:</label>
                        <div class="input-images-1" style="padding-top: .5rem;"></div>
                        @error('images')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="shop-address" class="form-label"> Restaurant Address: </label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="shop-address" name="address"
                            value="{{ $shop->shop_address }}">
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn shop-register-btn w-100 text-white">Submit</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/image-uploader.js') }}"></script>
    <script>
        // multiselect menus
        $(function(){
            $('#menus').multiSelect();
        });

        // multiple image select
        $(function () {

            $('.input-images-1').imageUploader();

            let preloaded = [
                {id: 1, src: 'https://picsum.photos/500/500?random=1'},
                {id: 2, src: 'https://picsum.photos/500/500?random=2'},
                {id: 3, src: 'https://picsum.photos/500/500?random=3'},
                {id: 4, src: 'https://picsum.photos/500/500?random=4'},
                {id: 5, src: 'https://picsum.photos/500/500?random=5'},
                {id: 6, src: 'https://picsum.photos/500/500?random=6'},
            ];

            // Input and label handler
            $('input').on('focus', function () {
                $(this).parent().find('label').addClass('active')
            }).on('blur', function () {
                if ($(this).val() == '') {
                    $(this).parent().find('label').removeClass('active');
                }
            });

            // Sticky menu
            let $nav = $('nav'),
                $header = $('header'),
                offset = 4 * parseFloat($('body').css('font-size')),
                scrollTop = $(this).scrollTop();

            // Initial verification
            setNav();

            // Bind scroll
            $(window).on('scroll', function () {
                scrollTop = $(this).scrollTop();
                // Update nav
                setNav();
            });

            function setNav() {
                if (scrollTop > $header.outerHeight()) {
                    $nav.css({position: 'fixed', 'top': offset});
                } else {
                    $nav.css({position: '', 'top': ''});
                }
            }
        });
    </script>
@endsection