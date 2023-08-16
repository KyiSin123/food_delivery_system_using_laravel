@extends('layouts.app')

@section('styles')
    <style> 
        .dropdown-menu {
            min-width: 7rem;
        }
        .card-height {
            min-height: 285px;
        }
        .image-height {
            height: 210px;
        }
        .unfavorite {
            display: block;
        }
        .favorite {
            display: none;
        }
        .display .unfavorite {
            display: none;
        }
        .display .favorite {
            display: block;
            color: red;
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
        .btn-pink {
            background-color: #fa5772;
        }
        .page-item.active .page-link {
            background-color: #fa5772;
            border-color: #fa5772;
        }
        .list-image {
            padding: 10px;
        }
    </style>
@endsection

@section('content')
<div class="shop-list col-10 my-5">
    <div class="row justify-content-end pb-4">
        <div class="col-lg-3 col-md-5">
            <form>
                <div class="input-group input-group">
                    <input class="form-control float-right" name="search" type="search"
                            value="{{ request('search') }}" placeholder="Search">

                    <div class="input-group-append">
                        <button class="btn btn-pink" type="submit"><i class="fas fa-search text-white"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        @foreach($shops as $shop)
        <div class="col-lg-3 col-md-4 position-relative">
            <div class="card position-relative card-height mb-3">
                <a href="{{ route('shops.show', $shop->id) }}" class="text-dark list-image text-decoration-none">
                    @foreach($shop->images as $image)
                        <img src="{{ asset($image->path) }}" class="card-img-top image-height rounded-top">
                        @break
                    @endforeach
                </a>
                <div class="card-body" data-id="{{ $shop->id }}">
                    <h3 class="shop-name"> {{ $shop->name }} </h3>
                    <div class="clearfix">
                        @foreach($shop->menu_types as $menu)
                            <span class="float-start"> {{ $menu->name }} </span>
                            @break
                        @endforeach
                        @if(Auth::check())
                            <div class="float-end pt-2 favorite-show-{{ $shop->id }} {{ in_array($shop->id, $favoritedShopIds) ? 'display' : '' }}">
                                <i class="fa-regular fa-heart unfavorite" onclick="favoriteAct({{ $shop->id }})"></i><i class="fa-solid fa-heart favorite" onclick="favoriteAct({{ $shop->id }})"></i>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="border-0 bg-transparent p-0" data-bs-toggle="modal" data-bs-target="#rate-{{ $shop->id }}">
                        <i class="fa-solid fa-star"></i>
                    </button> 
                    @if($shop->net_rating)
                        {{ $shop->net_rating->net_rating }}/5({{ $shop->net_rating->user_count }})
                    @endif 
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
                </div>
            </div>
            @can('edit-delete-shop', $shop)
            <div class="position-absolute vertical-icon">
                <div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('shops.edit', $shop->id) }}"> <i class="fa-solid fa-pen-to-square pe-1"></i> Edit</a></li>
                    </ul>
                </div>
            </div>
            @endcan            
        </div>
        @endforeach
        @if ($shops->hasPages())
            <div>
                {{ $shops->links() }}
            </div>
        @endif      
    </div>
</div>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function favoriteAct(id) {
        var url = '{{ route("favorite.add", ":id") }}';
        url = url.replace(':id', id);
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                id: id,
            },
            success: function() {
                console.log('success');
                $(`.favorite-show-${id}`).toggleClass('display');
            }
        })
    }
</script>
@endsection  
