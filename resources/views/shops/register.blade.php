@extends('layouts.app')

@section('content')
    <div class="restaurant-register">
        <div class="col-8 shop-register-form">
            <div class="row p-5">
                <div class="col-6 partner">
                    <h1> Partner with us </h1>
                    <span>We're hungry for the best things in life: delicious food, exploring the city and bringing the first bite of food to our customers.<br><br>foodpanda is multi-national, fast-growing business that maintains its appeal as localised service with community ambition.</span>
                </div>
                <div class="col-6">
                    <div class="card w-100 p-5">
                        <form method="POST" action="{{ route('shops.register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="shop-name" class="form-label"> Restaurant/Shop Name: </label>
                                <input type="text" class="form-control @error('shop_name') is-invalid @enderror" id="shop-name" name="shop_name" 
                                    value="{{ old('shop_name') }}">
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
                                            {{ in_array($menu->id, old('menus') ?: []) ? 'selected' : '' }}>{{ $menu['name'] }}
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
                                    value="{{ old('owner_name') }}">
                                @error('owner_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{ $message }} </strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="contact-number" class="form-label"> Contact Number: </label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact-number" placeholder="09123456789" name="contact_number"
                                    value="{{ old('contact_number') }}">
                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{ $message }} </strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label"> Email address: </label>
                                <input type="email" class="form-control @error('shop_email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="example@gmail.com" name="shop_email"
                                    value="{{ old('shop_email') }}">
                                @error('shop_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{ $message }} </strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{ $message }} </strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-field mb-4">
                                <label class="active">Upload your menu photos:</label>
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
                                    value="{{ old('address') }}">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{ $message }} </strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn shop-register-btn text-white w-100">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
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