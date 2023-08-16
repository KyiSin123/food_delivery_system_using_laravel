@extends('layouts.app')

@section('styles')
    <style>
        * {box-sizing: border-box}
        body {font-family: Verdana, sans-serif; margin:0}
        .mySlides {display: none}
        img {vertical-align: middle;}

        /* Slideshow container */
        .slideshow-container {
        max-width: 1000px;
        position: relative;
        margin: auto;
        }

        /* Next & previous buttons */
        .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -22px;
        color: #000;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
        text-decoration: none;
        }

        /* Position the "next button" to the right */
        .next {
        right: 0;
        border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover, .next:hover {
        background-color: rgba(0,0,0,0.8);
        }

        /* The dots/bullets/indicators */
        .dot {
        cursor: pointer;
        height: 10px;
        width: 10px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
        }

        a:hover {
            color: #fa5772;
        }

        .active, .dot:hover {
        background-color: #717171;
        }

        /* Fading animation */
        .fade {
        animation-name: fade;
        animation-duration: 1.5s;
        }

        @keyframes fade {
        from {opacity: .4} 
        to {opacity: 1}
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
        .prev, .next,.text {font-size: 11px}
        }
        .dropdown-menu {
            min-width: 6rem;
        }
        .order-action {
            font-size: 12px;
        }
        .fa-star {
            color: #FFD700;
        }
        .rate {
         float: left;
         height: 46px;
         padding: 0 10px;
         }
         .rate:not(:checked) > input {
         position:absolute;
         display: none;
         }
         .rate:not(:checked) > label {
         float:right;
         width:1em;
         overflow:hidden;
         white-space:nowrap;
         cursor:pointer;
         font-size:30px;
         color:#ccc;
         }
         .rated:not(:checked) > label {
         float:right;
         width:1em;
         overflow:hidden;
         white-space:nowrap;
         cursor:pointer;
         font-size:30px;
         color:#ccc;
         }
         .rate:not(:checked) > label:before {
         content: '★ ';
         }
         .rate > input:checked ~ label {
         color: #ffc700;
         }
         .rate:not(:checked) > label:hover,
         .rate:not(:checked) > label:hover ~ label {
         color: #deb217;
         }
         .rate > input:checked + label:hover,
         .rate > input:checked + label:hover ~ label,
         .rate > input:checked ~ label:hover,
         .rate > input:checked ~ label:hover ~ label,
         .rate > label:hover ~ input:checked ~ label {
         color: #c59b08;
         }
         .star-rating-complete{
            color: #c59b08;
         }
         .rating-container .form-control:hover, .rating-container .form-control:focus{
         background: #fff;
         border: 1px solid #ced4da;
         }
         .rating-container textarea:focus, .rating-container input:focus {
         color: #000;
         }
         .rated {
         float: left;
         height: 46px;
         padding: 0 10px;
         }
         .rated:not(:checked) > input {
         position:absolute;
         display: none;
         }
         .rated:not(:checked) > label {
         float:right;
         width:1em;
         overflow:hidden;
         white-space:nowrap;
         cursor:pointer;
         font-size:30px;
         color:#ffc700;
         }
         .rated:not(:checked) > label:before {
         content: '★ ';
         }
         .rated > input:checked ~ label {
         color: #ffc700;
         }
         .rated:not(:checked) > label:hover,
         .rated:not(:checked) > label:hover ~ label {
         color: #deb217;
         }
         .rated > input:checked + label:hover,
         .rated > input:checked + label:hover ~ label,
         .rated > input:checked ~ label:hover,
         .rated > input:checked ~ label:hover ~ label,
         .rated > label:hover ~ input:checked ~ label {
         color: #c59b08;
         }
        .star-rate {
            font-size: 14px;
        }
    </style>
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-lg-8 col-md-8 col-12">
            <div class="slideshow-container">
                @foreach($shop->images as $image)
                <div class="mySlides">
                    <img src="{{ asset($image->path) }}" class="w-100 slideshow-image">
                </div>
                @endforeach
                <a class="prev" onclick="plusSlides(-1)">❮</a>
                <a class="next" onclick="plusSlides(1)">❯</a>
            </div>
            <br>
            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span> 
                <span class="dot" onclick="currentSlide(2)"></span> 
                <span class="dot" onclick="currentSlide(3)"></span> 
            </div>
            <div class="shop-detail col-10">
                <h1 class="shop-name pt-3">
                    {{ $shop->name }}
                </h1>
                <div class="star-rate">
                    <button type="button" class="border-0 bg-transparent p-0 mb-3" data-bs-toggle="modal" data-bs-target="#rate-{{ $shop->id }}">
                        <i class="fa-solid fa-star"></i>
                    </button> 
                    @if($shop->net_rating)
                        {{ $shop->net_rating->net_rating }}/5({{ $shop->net_rating->user_count }})
                    @endif
                </div>                 
                <div class="modal fade" id="rate-{{ $shop->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Review</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <form class="py-2 px-4" action="{{ route('review.store', $shop->id) }}" style="box-shadow: 0 0 10px 0 #ddd;" method="POST" autocomplete="off">
                                            @csrf
                                            <div class="form-group row">
                                            <input type="hidden" name="booking_id" value="">
                                            <div class="col">
                                                <div class="rate">
                                                    <input type="radio" id="star5" class="rate" name="rating" value="5"/>
                                                    <label for="star5" title="text">5 stars</label>
                                                    <input type="radio" checked id="star4" class="rate" name="rating" value="4"/>
                                                    <label for="star4" title="text">4 stars</label>
                                                    <input type="radio" id="star3" class="rate" name="rating" value="3"/>
                                                    <label for="star3" title="text">3 stars</label>
                                                    <input type="radio" id="star2" class="rate" name="rating" value="2">
                                                    <label for="star2" title="text">2 stars</label>
                                                    <input type="radio" id="star1" class="rate" name="rating" value="1"/>
                                                    <label for="star1" title="text">1 star</label>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="mt-3 clearfix">
                                            <button class="btn btn-sm py-2 px-3 ms-2 btn-primary float-end">Submit
                                            </button>
                                            <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="row">
                    @foreach($shop->menu_types as $menu)
                        <li class="col-lg-2 col-md-3 col-4"> {{ $menu->name }} </li>
                    @endforeach
                </ul>
                <span class="text-muted ps-1"><i class="fa-solid fa-location-dot"></i> {{ $shop->shop_address }} </span> <br>
                @can('add-menu', $shop)
                <a href="{{ route('menus.create', $shop->id) }}" class="btn add-menu-btn mt-2 p-1"><i class="fa-solid fa-circle-plus"></i> Add Menu </a>
                @endcan
                @include('shops.menus.index', ['menus' => $shop->menus, 'shop_id' => request('id')])
            </div>
        </div>
        <div class="col-lg-4 col-md-4 end-0" id="cartId">
            <div class="card p-3 shadow">
                <h4 class="text-center"> Your Cart </h4>
                @if(!session('cart'))
                    <p class="text-center text-muted"> Start adding items to your cart </p>
                @endif
                @php 
                    $total = 0;
                    $deliveryFee = 0;
                @endphp
                @foreach((array) session('cart') as $id => $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                @endforeach
                @php $deliveryFee = $total * 0.08 @endphp
                @if(session('cart'))
                    <h6 class="text-center mt-2"> Your order from {{ $shop->name }}</h6>
                    @foreach(session('cart') as $id => $details)
                        <aside class="order-menu-list" data-id='{{ $id }}'>
                            data-idheade<div class="row clearfix text-muted mt-3">
                                <div class="col float-start">
                                    {{ $details['name'] }}
                                </div>
                                <div class="col float-end text-end">
                                    MMK {{ $details['price'] }}
                                </div>
                            </div>
                            <div class="row clearfix my-3">
                                <div class="col float-end text-end add-menu-btn">
                                    @if($details['quantity'] === 1)
                                        <i class="fa-solid fa-trash-can remove-cart"></i>
                                    @else
                                        <i class="fa-solid fa-minus subtract"></i>
                                    @endif
                                    <input type="text" value="{{ $details['quantity'] }}" class="quantity update-cart text-center" disabled /> 
                                     <i class="fa-solid fa-plus count"></i>
                                </div>
                            </div>
                        </aside>
                    @endforeach
                @endif
                <div class="payment border-top">
                    <div class="row clearfix text-muted mt-3">
                        <div class="col float-start">
                            Subtotal
                        </div>
                        <div class="col float-end text-end">
                            MMK {{ $total }}
                        </div>
                    </div>
                    @if(session('cart'))
                    <div class="row clearfix text-muted mt-1" style="font-size:13px">
                        <div class="col float-start">
                            Delivery Fee
                        </div>
                        <div class="col float-end text-end">
                            MMK {{ $deliveryFee }}
                        </div>
                    </div>
                    @endif
                    <div class="row clearfix mt-3">
                        <div class="col float-start">
                            Total <span class="tax text-muted"> (Incl. tax) </span>
                        </div>
                        <div class="col float-end text-end">
                            MMK {{ $total + $deliveryFee }}
                        </div>
                    </div>
                    @if(Session::get('cart'))                        
                        <button type="button" class="btn w-100 py-2 mt-3 checkout-btn text-white" onclick="checkout({{ $shop }})">
                            Go to checkout
                        </button>
                    @else
                        <button type="button" class="btn btn-secondary w-100 py-2 mt-3" disabled>
                            Go to checkout
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="orderForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Fill Your Information: </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="store-info" autocomplete="off">
                        @csrf
                        <div class="row mt-4">
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul class="text-center"></ul>
                            </div>
                            <div class="col-4"> 
                                <label for="ph-number" > Ph Number: </label>
                            </div>
                            <div class="col-8"> 
                                <input type="text" id="ph-number" class="form-control" name="ph_number"> 
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4"> 
                                <label for="address" > Address: </label> 
                            </div>
                            <div class="col-8"> 
                                <input type="text" id="address" class="form-control" name="address">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="button" id="store-info" class="btn profile-edit">Submit</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) {slideIndex = 1}    
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";  
            dots[slideIndex-1].className += " active";
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.count').on('click', function(e) {
            e.preventDefault();
            var ele = $(this);

            $.ajax({
                url: '{{ route('update.cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("aside").attr("data-id"), 
                    quantity: ele.parents("aside").find(".quantity").val()
                },
                success: function (response) {
                    window.location.reload();
                }
            })
        });
        
        $(".remove-cart").on('click', function (e) {
            e.preventDefault();
    
            var ele = $(this);
            $.ajax({
                url: '{{ route('cart.remove') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("aside").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".subtract").on('click', function(e) {
            e.preventDefault();
            var ele = $(this);

            $.ajax({
                url: '{{ route('cart.subtract') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("aside").attr("data-id"), 
                    quantity: ele.parents("aside").find(".quantity").val()
                },
                success: function (response) {
                    window.location.reload();
                }
            })
        })

        function checkout() {
            $.get("{{ route('shops.checkout', request('id')) }}", function(data) {
                $('#ph-number').val(data.ph_number);
                $('#address').val(data.address);
                $('#orderForm').modal('show');
            });
        }

        $('#store-info').click(function(e) {
            e.preventDefault();
            var url = '{{ route("shops.checkout", request('id')) }}';
            $.ajax({
                type: "POST",
                url: url,
                data: $('#store-info').serialize(),
                dataType: 'json',
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        $('#orderForm').modal('hide');
                        window.location.reload();
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }
    </script>
@endsection