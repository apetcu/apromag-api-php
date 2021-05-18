<?php

namespace App\Http\Routes\Auth\Models;

use App\Http\Requests\BaseRequest;

class RegisterAuthRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:30',
            'role' => 'required',
            'vendor.businessName' => 'required_if:role,VENDOR',
            'vendor.address' => 'required_if:role,VENDOR'
        ];
    }
}
