<?php

namespace App\Http\Controllers\Admin;

use App\Models\MenuType;
use App\Models\MenuTypeShop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminMenuTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuTypes = MenuType::filter(request('search'))
            ->sort()
            ->paginate(10);

        return view('admins.menuTypes.index', compact('menuTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "type_name" => ["required", "max:191"],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }
        MenuType::create([
            "name" => $request->type_name,
        ]);

        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "type_name" => ["required", "max:191"],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }
        $type = MenuType::findOrFail($id)->update([
            "name" => $request->type_name,
        ]);

        return response()->json($type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = MenuType::findOrFail($id);
        MenuType::findOrFail($id)->delete();
        MenuTypeShop::where('menu_type_id', $type->id)->delete();

        return back();
    }
}
