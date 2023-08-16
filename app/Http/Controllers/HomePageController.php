<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function index() {
        $shops = Shop::with('menu_types')
            ->where('is_published', true)        
            ->filter(request('search'))
            ->sort()
            ->paginate(8);
        $favoritedShopIds = [];
        if(Auth::check()) {
            $favoritedShops = Shop::whereHasFavorite(
                auth()->user()
            )->get();
            
            $i = 0;
            foreach($favoritedShops as $favShop) {
                $favoritedShopIds[$i++] = $favShop->id;
            }
        }

        return view('index', compact('shops', 'favoritedShopIds'));
    }
}
