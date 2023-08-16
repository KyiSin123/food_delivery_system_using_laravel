<header>
    <div class="nav-container shadow-sm">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6 col-md-6 col-4">
                    <a href="{{ route('home') }}" class="text-decoration-none"> <div class="logo"> Delicious Food </div> </a>
                </div>
                <div class="col-lg-6 col-md-6 col-8">
                    <div class="large-scr clearfix">
                        @guest
                            @if (Route::has('login'))
                                <div class="ml-4 float-end">
                                    <a href="{{ route('login') }}" class="text-decoration-none nav-icon">
                                        <i class="fa-solid fa-user"></i> LOGIN </a>
                                </div>
                            @endif
                        @else
                        <div class="dropdown">
                            <a class="text-decoration-none nav-profile dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user pe-1"></i> {{ auth()->user()->name }}
                            </a>
                        
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('users.show', auth()->id()) }}">View Profile</a></li>
                            <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                        <button class="dropdown-item btn" type="submit">Logout</button>
                                    </form>
                            </li>
                            </ul>
                        </div>
                        <a href="{{ route('shops.favorite') }}" class="ps-4">
                            <div class="fav-icon">
                                <i class="fa-regular fa-heart"></i>
                            </div>
                        </a>                    
                        @endguest
                        <div class="ml-4 float-end">
                            @if(session()->has('shop_id'))
                                <a href="{{ route('shops.show', session()->get('shop_id')) }}" class="text-decoration-none nav-icon">
                                    <i class="fa-solid fa-cart-shopping"></i> </a>
                            @else
                                <a href="#" class="text-decoration-none nav-icon">
                                    <i class="fa-solid fa-cart-shopping"></i> </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    @yield('banner')
</header>