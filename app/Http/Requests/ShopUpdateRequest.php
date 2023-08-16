<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'shop_name' => ['required', 'max:191'],
            'menus' => ['required', 'array'],
            'owner_name' => ['required', 'max:191'],
            'contact_number' => ['required', 'digits:11'],
            'shop_email' => ['required', 'max:191'],
            'address' => ['required'],
        ];
    }
}
