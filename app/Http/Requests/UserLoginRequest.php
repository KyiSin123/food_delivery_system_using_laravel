<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'email' => ['required', 'max:191'],
            'password' => ['required', 'max:191'],
        ];
    }
    
    /**
     * Get the needed authorization credentials from the request.
     *
     * @return array
     */
    public function getCredentials()
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        return $credentials;
    }
}
