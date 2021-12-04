<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\BaseRequest;

class RegisterRequest extends BaseRequest
{
    protected $validations = [
        'name.required',
        'name.min',
        'name.max',
        'name.string',
        'email.required',
        'email.email',
        'email.unique',
        'password.required',
        'password.regex',
    ];

    protected $label  = 'users';

    public function rules()
    {
        return [
            'name'      => 'required|string|min:3|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
        ];
    }
}
