<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Models\Image;
use App\Models\Order;
use App\Models\Rating;
use App\Models\MenuType;
use App\Models\BuyerInfo;
use App\Models\NetRating;
use App\Models\OrderMenu;
use App\Models\MenuTypeShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maize\Markable\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ShopUpdateRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ShopRegisterRequest;

class ShopController extends Controller
{
    public function create()
    {
        $menus = MenuType::all();

        return view('shops.register', compact('menus'));
    }

    public function store(ShopRegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->owner_name,
                'email' => $request->shop_email,
                'password' => Hash::make($request->password),
                'status' => 'shopkeeper',
            ]);
            $shop = Shop::create([
                'user_id' => $user->id,
                'name' => $request->shop_name,
                'ph_number' => $request->contact_number,
                'shop_address' => $request->address,
                'is_published' => false,
            ]);
            for ($i = 0; $i < count($request->menus); $i++) {
                $menu = MenuTypeShop::create([
                    'shop_id' => $shop->id,
                    'menu_type_id' => $request->menus[$i],
                ]);
            };
            for ($i = 0; $i < count($request->images); $i++) {
                $fileName = uniqid() . '.' . $request->images[$i]->getClientOriginalExtension();
                $path = $request->images[$i]->storeAs('images', $fileName, 'public');
                $image = Image::create([
                    'imageable_id' => $shop->id,
                    'imageable_type' => get_class($shop),
                    'name' => $fileName,
                    'path' => 'storage/' . $path,
                ]);
            }
            DB::commit();

            return redirect()->route('home');
        } catch (Throwable $th) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . '[line: ' . __LINE__ . '][Shop registration failed] Message: ' . $th->getMessage());
            DB::rollBack();
        }
    }

    public function index()
    {
        $shops = Shop::with('menu_types')
            ->with('net_rating')
            ->where('is_published', true)
            ->filter(request('search'))
            ->sort()
            ->paginate(8);
        $favoritedShopIds = [];
        if (Auth::check()) {
            $favoritedShops = Shop::whereHasFavorite(
                auth()->user()
            )->get();

            $i = 0;
            foreach ($favoritedShops as $favShop) {
                $favoritedShopIds[$i++] = $favShop->id;
            }
        }

        return view('shops.list', compact('shops', 'favoritedShopIds'));
    }

    public function show($id)
    {
        $shop = Shop::with('menus')->findOrFail($id);

        return view('shops.show', compact('shop'));
    }

    public function edit($id)
    {
        $shop = Shop::find($id);
        if (!Gate::allows('edit-delete-shop', $shop)) {
            abort(403);
        } else {
            $menus = MenuType::all();

            return view('shops.edit', compact('shop', 'menus'));
        }
    }

    public function update(ShopUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            Shop::where('id', $id)->update([
                'name' => $request->shop_name,
                'ph_number' => $request->contact_number,
                'shop_address' => $request->address,
            ]);
            $shop = Shop::find($id);
            User::where('id', $shop->user_id)->update([
                'name' => $request->owner_name,
                'email' => $request->shop_email,
            ]);
            MenuTypeShop::where('shop_id', $id)->delete();
            foreach ($request->menus as $menu) {
                MenuTypeShop::create([
                    'shop_id' => $id,
                    'menu_type_id' => $menu,
                ]);
            }
            if ($request->hasFile('images')) {
                foreach ($shop->images as $image) {
                    unlink($image->path);
                }
                Image::where('imageable_id', $id)
                    ->where('imageable_type', get_class($shop))
                    ->delete();
                for ($i = 0; $i < count($request->images); $i++) {
                    $fileName = uniqid() . '.' . $request->images[$i]->getClientOriginalExtension();
                    $path = $request->images[$i]->storeAs('images', $fileName, 'public');
                    $image = Image::create([
                        'imageable_id' => $shop->id,
                        'imageable_type' => get_class($shop),
                        'name' => $fileName,
                        'path' => 'storage/' . $path,
                    ]);
                }
            }
            DB::commit();
        } catch (Throwable $th) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . '[line: ' . __LINE__ . '][Shop registration failed] Message: ' . $th->getMessage());
            DB::rollBack();
        }

        return redirect()->route('shops.show', $shop->id);
    }

    public function favoriteAdd(Request $request, $id)
    {
        $shop = Shop::find($id);
        $user = auth()->user();
        Favorite::toggle($shop, $user);

        return redirect()->back();
    }

    public function favoriteList()
    {
        $shops = Shop::whereHasFavorite(
            auth()->user()
        )->get();

        return view('shops.favoritedList', compact('shops'));
    }

    public function getBuyerInfo($id) {
        $buyerInfo = BuyerInfo::where('user_id', auth()->id())->first();

        return response()->json($buyerInfo);
    }

    public function checkout(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ph_number' => ['required', 'digits:11'],
            'address' => ['required', 'max:191'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }

        $buyerInfo = BuyerInfo::where('user_id', auth()->id())->first();
        if($buyerInfo === null) {
            BuyerInfo::create([
                'user_id' => auth()->id(),
                'ph_number' => $request->ph_number,
                'address' => $request->address,
            ]);
        } else {
            BuyerInfo::findOrFail($buyerInfo->id)->update([
                'user_id' => auth()->id(),
                'ph_number' => $request->ph_number,
                'address' => $request->address,
            ]);
        }

        $totalPrice = 0;
        $cart = session()->get('cart');
        foreach ($cart as $key => $value) {
            $totalPrice += $cart[$key]['price'];
        }

        $order = Order::create([
            'shop_id' => $id,
            'total_price' => $totalPrice,
        ]);

        foreach ($cart as $key => $value) {
            OrderMenu::create([
                'order_id' => $order->id,
                'menu_id' => $key,
            ]);
        }
        session()->forget(['cart', 'shop_id']);

        return response()->json(["success" => "Ordering success!"], 200);
    }

    public function reviewStore(Request $request, $id)
    {
        $rating = Rating::create([
            'shop_id' => $id,
            'user_id' => auth()->id(),
            'star_rating' => $request->rating,
        ]);

        $oneStarCount = Rating::where('shop_id', $id)
            ->where('star_rating', 1)
            ->count();
        $twoStarCount = Rating::where('shop_id', $id)
            ->where('star_rating', 2)
            ->count();
        $threeStarCount = Rating::where('shop_id', $id)
            ->where('star_rating', 3)
            ->count();
        $fourStarCount = Rating::where('shop_id', $id)
            ->where('star_rating', 4)
            ->count();
        $fiveStarCount = Rating::where('shop_id', $id)
            ->where('star_rating', 5)
            ->count();

        $net_rating = (5 * $fiveStarCount + 4 * $fourStarCount + 3 * $threeStarCount + 2 * $twoStarCount + 1 * $oneStarCount) / ($fiveStarCount + $fourStarCount + $threeStarCount + $twoStarCount + $oneStarCount);
        $count = Rating::where('shop_id', $id)->count();
        $netCount = NetRating::where('shop_id', $id)->count();

        if ($netCount > 0) {
            NetRating::where('shop_id', $id)->update([
                'shop_id' => $id,
                'net_rating' => $net_rating,
                'user_count' => $count,
            ]);
        } else {
            NetRating::create([
                'shop_id' => $id,
                'net_rating' => $net_rating,
                'user_count' => $count,
            ]);
        }

        return redirect()->back();
    }
}
