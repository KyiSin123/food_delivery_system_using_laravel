@extends('layouts.app')

@section('styles')
    <style> 
        .card-height {
            min-height: 285px;
        }
        .image-height {
            height: 210px;
        }
        .favorite-list {
            background-image: url('/img/favorite.jpg');
            background-size: cover;
            min-height: 500px;
        }
        .no-favorite {
            padding-top: 170px;
        }
        @media (min-width:768px) and (max-width:1180px) {
            .image-height {
                height: 23.438vw;
            }
            .card-height {
                min-height: 33.203vw;
            }
        }
    </style>
@endsection

@section('content')
<div class="favorite-list">
    <div class="shop-list col-10 py-5">
        @if($shops->isNotEmpty())
            <h2 class="text-center pb-5"> Your Favorited Shops </h2>
            <div class="row">
                @foreach($shops as $shop)
                <div class="col-lg-3 col-md-4">
                    <a href="{{ route('shops.show', $shop->id) }}" class="text-dark text-decoration-none">
                        <div class="card position-relative card-height">
                            @foreach($shop->images as $image)
                                <img src="{{ asset($image->path) }}" class="card-img-top image-height">
                                @break
                            @endforeach
                            <div class="card-body" data-id="{{ $shop->id }}">
                                <h3 class="create-post shop-name"> {{ $shop->name }} </h3>
                                @foreach($shop->menu_types as $menu)
                                    <span> {{ $menu->name }} </span>
                                    @break
                                @endforeach
                            </div>
                        </div>   
                    </a>         
                </div>
                @endforeach      
            </div>
        @else
            <h1 class="text-center no-favorite"> You still have no favorite shops to show. </h1>
        @endif
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
