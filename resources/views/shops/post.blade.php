@extends('layouts.app')
@section('styles')
    <style>
        .input-field {
            position: relative;
            margin-top: 2.2rem;
        }
    </style>
@endsection
@section('content')
    <div class="post-form p-5">
        <div class="col-6 post-create">
            <div class="card p-5 shadow">
                <h2 class="create-post">Update Your Shop Info:</h2>
                <form method="POST" action="{{ route('shops.edit') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-4">
                        <label for="food-name" class="form-label"> Food Name: </label>
                        <input type="text" id="food-name" name="food_name" class="form-control @error('food_name') is-invalid @enderror"
                            value="{{ old('food_name') }}">
                        @error('food_name')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="offer" class="form-label"> Offer: </label>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="offer" id="offer-radio1" value="free delivery">
                                    <label class="form-check-label" for="offer-radio1">
                                        Free Delivery
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="offer" id="offer-radio2" value="deals">
                                    <label class="form-check-label" for="offer-radio2">
                                        Deals
                                    </label>
                                </div>
                            </div>
                            @error('offer')
                                <span class="invalid-feedback" role="alert">
                                    <strong> {{ $message }} </strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="input-field mb-4">
                        <label class="active">Images:</label>
                        <div class="input-images-1" style="padding-top: .5rem;"></div>
                        @error('images')
                                <span class="invalid-feedback" role="alert">
                                    <strong> {{ $message }} </strong>
                                </span>
                        @enderror
                    </div>                                    
                    <div class="mb-4">
                        <label for="description" class="form-label"> Food Description: </label>
                        <input type="text" id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                            value="{{ old('description') }}">
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="price" class="form-label"> Price: </label>
                        <input type="text" id="price" name="price" class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price') }}">
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="other" class="form-label"> Other Variety: </label>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="other" id="offer-radio1" value="casual">
                                    <label class="form-check-label" for="offer-radio1">
                                        Casual
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="other" id="offer-radio2" value="halal">
                                    <label class="form-check-label" for="offer-radio2">
                                        Halal
                                    </label>
                                </div>
                            </div>
                            @error('other')
                                <span class="invalid-feedback" role="alert">
                                    <strong> {{ $message }} </strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn mt-3 py-2 w-100 post-submit text-white"> Submit </button>
                </form>
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