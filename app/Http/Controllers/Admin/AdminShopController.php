<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;
use App\Models\User;
use App\Models\Image;
use App\Models\Order;
use App\Mail\RejectMail;
use App\Models\MenuType;
use App\Mail\ApproveMail;
use App\Models\MenuTypeShop;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ShopUpdateRequest;

class AdminShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::filter(request('search'))
            ->sort()
            ->paginate(10);

        return view('admins.shops.index', compact('shops'));
    }

    public function approveMail($id)
    {
        $shop = Shop::findOrFail($id);
        Mail::to($shop->user->email)->send(new ApproveMail());
        $shop->is_published = true;
        $shop->status = 'approved';
        $shop->save();
 
        return redirect()->route('admins.shops.show', $id)->with('success', 'Great! Approve Mail has successfully sent!');
    }

    public function rejectMail($id)
    {
        $shop = Shop::findOrFail($id);
        Mail::to($shop->user->email)->send(new RejectMail());
        $shop->is_published = false;
        $shop->status = 'rejected';
        $shop->save();

        return back()->with('success', 'Great! Decline Mail has successfully sent!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop = Shop::findOrFail($id);

        return view('admins.shops.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        $menus = MenuType::all();

        return view('admins.shops.edit', compact('shop', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ShopUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopUpdateRequest $request, $id)
    {
        try{
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
            foreach($request->menus as $menu) {
                MenuTypeShop::create([
                    'shop_id' => $id,
                    'menu_type_id' => $menu,
                ]);
            }
            if($request->hasFile('images')) {
                foreach($shop->images as $image) {
                    unlink($image->path);
                }
                Image::where('imageable_id', $id)
                    ->where('imageable_type', get_class($shop))
                    ->delete();
                for($i = 0; $i < count($request->images); $i++) {
                    $fileName = uniqid() . '.' . $request->images[$i]->getClientOriginalExtension();
                    $path =  $request->images[$i]->storeAs('images', $fileName,'public');
                    $image = Image::create([
                        'imageable_id' => $shop->id,
                        'imageable_type' => get_class($shop),
                        'name' => $fileName,
                        'path' => 'storage/'.$path,
                    ]);
                }
            }
            DB::commit();
        } catch (Throwable $th) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . '[line: ' . __LINE__ . '][Shop registration failed] Message: ' . $th->getMessage());
            DB::rollBack();
        }

        return redirect()->route('admins.shops.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);
        Shop::findOrFail($id)->delete();
        User::findOrFail($shop->user_id)->delete();

        return redirect()->route('admins.shops.index');
    }

    public function showReceipt() {
        $orders = Order::filter(request('search'))
            ->latest()->paginate(10);

        return view('admins.receipts.index', compact('orders'));
    }
}
