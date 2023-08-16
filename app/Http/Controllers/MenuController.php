<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Shop;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\MenuStoreRequest;
use App\Http\Requests\MenuUpdateRequest;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $menus = Menu::where('shop_id', $id)->get();

        return view('menus.show', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $shop = Shop::find($id);
        if (! Gate::allows('add-menu', $shop)) {
            abort(403);
        } else {
            
            return view('shops.menus.create', compact('shop'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MenuStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuStoreRequest $request, $id)
    {
        $menu = Menu::create([
            'shop_id' => $id,
            'name' => $request->menu_name,
            'description' => $request->description,
            'price' => $request->price,
            'status' => 'Available',
        ]);
        
        $fileName = uniqid() . '.' . $request->image->getClientOriginalExtension();
        $path =  $request->image->storeAs('images', $fileName,'public');
        $image = Image::create([
            'imageable_id' => $menu->id,
            'imageable_type' => get_class($menu),
            'name' => $fileName,
            'path' => 'storage/'.$path,
        ]);

        return redirect()->route('shops.show', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::with('image')->findOrFail($id);
        $shop = Shop::findOrFail($menu->shop_id);
        if (! Gate::allows('edit-delete-menu', $shop)) {
            abort(403);
        } else {

            return view('shops.menus.edit', compact('menu'));
        }
    }

    public function update(MenuUpdateRequest $request, $id) {
        Menu::findOrFail($id)->update([
            'name' => $request->menu_name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        $menu = Menu::findOrFail($id);
        if(isset($request->status)) {
            $menu->status = 'Available';
        } else {
            $menu->status = 'Sold Out';
        }
        $menu->save();

        if($request->hasFile('image')) {
            unlink($menu->image->path);
            Image::where('imageable_id', $id)
                ->where('imageable_type', get_class($menu))
                ->delete();
            
            //updating image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('images', $imageName, 'public');
            $image = Image::create([
                "imageable_id" => $menu->id,
                "imageable_type" => get_class($menu),
                'name' => $imageName,
                'path' => 'storage/images/' . $imageName,
            ]);
        }

        return redirect()->route('shops.show', $menu->shop_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        unlink($menu->image->path);
        Image::where('imageable_id', $id)
            ->where('imageable_type', get_class($menu))
            ->delete();
        Menu::findOrFail($id)->delete();

        return redirect()->route('shops.show', $menu->shop_id);
    }

    public function addToCart(Request $request, $id) {
        $menu = Menu::findOrFail($id);
        if(session()->has('cart')) {
            $cart = session()->get('cart');
            $lastId = array_key_last($cart);
            if($menu->shop->name != $cart[$lastId]['shop_name']) {
                session()->forget('cart');
                $cart = session()->get('cart');
                session()->put('cart', $cart);
            }
        }
        $cart = session()->get('cart', []);  
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "shop_name" => $menu->shop->name,
                "name" => $menu->name,
                "quantity" => 1,
                "price" => $menu->price,
            ];
        }          
        session()->put('cart', $cart);
        session()->put('shop_id', $menu->shop_id);

        return redirect()->back();
    }

    public function updateCart(Request $request) {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity + 1;
            session()->put('cart', $cart);
        }
    }

    public function subtractCart(Request $request) {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity - 1;
            session()->put('cart', $cart);
        }
    }

    public function removeFromCart(Request $request) {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
    }
}
