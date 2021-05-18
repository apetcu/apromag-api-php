<?php

namespace App\Http\Routes\Auth\Models;

use App\Http\Requests\BaseRequest;

class PasswordResetWithTokenRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'password' => 'required|min:6|max:30',
            'confirmPassword' => 'required|min:6|max:30'
        ];
    }
}
