<?php

namespace App\Http\Routes\Auth\Models;

use App\Http\Requests\BaseRequest;

class LoginAuthRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ];
    }
}
