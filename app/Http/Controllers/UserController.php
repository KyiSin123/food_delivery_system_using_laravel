<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BuyerInfo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function show($id) {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($id)],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }
        User::findOrFail($id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json();
    }

    public function changePassword(Request $request, $id) {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'max:255'],
            'password_confirmation' => ['required', 'same:new_password'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }

        if (Hash::check($request->current_password, $user->password)) {
            User::where('id', $id)->update([
                "password" => Hash::make($request->new_password),
            ]);
            return response()->json(["message" => "Password Updating Succeed!"], 200);
        } else {
            return response()->json(["message" => "The credential does not match."], 200);
        }
    }

    public function storeInfo(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'ph_number' => ['required', 'digits:11'],
            'address' => ['required', 'max:191'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }

        BuyerInfo::create([
            'user_id' => $id,
            'ph_number' => $request->ph_number,
            'address' => $request->address,
        ]);

        return response()->json();
    }
}
