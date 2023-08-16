<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
        // dd(request());
        return [
            'food_name' => ['required', 'max:191'],
            'menus' => ['required'],
            'offer' => ['required'],
            'images' => ['required'],
            'images.*' => ['required', 'mimes:jpeg,jpg,png', 'max:2000'],
            'description' => ['required', 'max:191'],
            'price' => ['required', 'max:191'],
            'other' => ['required', 'max:191'],
        ];
    }
}
