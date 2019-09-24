<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class User extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|min:2|max:191',
            'last_name' => 'required|min:2|max:191',
            'email' => 'required|email|unique:users',
            'document' => 'required|min:11|max:14|unique:users',
            'sector' => 'required',
            'function' => 'required',

            //Contact
            'primary_contact' => 'required',
            'secondary_contact' => 'required',

            //Access
            'username' => 'required|unique:users',
            'password' => 'required',

        ];
    }
}
