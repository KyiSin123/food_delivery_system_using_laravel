@extends('layouts.app')

@section('styles')
    <style>
        .switch {
        position: relative;
        display: inline-block;
        width: 57px;
        height: 29px;
        }

        .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
        }

        .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        }

        .slider:before {
        position: absolute;
        content: "";
        height: 23px;
        width: 23px;
        left: 2px;
        bottom: 3px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        }

        input:checked + .slider {
        background-color: #fa5772;
        }

        input:focus + .slider {
        box-shadow: 0 0 1px #fa5772;
        }

        input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
        border-radius: 34px;
        }

        .slider.round:before {
        border-radius: 50%;
        }
        .img-width {
            width: 150px;
            height: 150px;
        }
    </style>
@endsection

@section('content')
    <div class="post-form p-5">
        <div class="col-lg-6 col-md-9 col-12 post-create">
            <div class="card p-lg-5 p-md-5 p-3 shadow">
                <h2 class="create-post">Edit Menu:</h2>
                <form method="POST" action="{{ route('menus.edit', $menu->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="my-3">
                        <label for="menu-name" class="form-label"> Menu Name: </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="menu-name" name="menu_name" 
                            value="{{ $menu->name }}">
                        @error('menu_name')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label"> Description for your menu: </label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            value="{{ $menu->description }}">
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label"> Price: </label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                            value="{{ $menu->price }}">
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-field mb-4">
                        <label for="image" class="form-label">Add your menu photo:</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                        <img src="{{ asset($menu->image->path) }}" class="img-width mt-2 ">
                    </div>
                    <div class="input-field mb-4">
                        Sold Out
                        <label class="switch mx-2">
                            <input type="checkbox" {{ $menu->status === 'Available' ? 'checked' : '' }} name="status" value="{{ $menu->status }}">
                            <span class="slider round"></span>
                        </label>
                        Available
                    </div>
                    <button type="submit" class="btn shop-register-btn w-100 text-white">Update</button>
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