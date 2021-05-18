<?php

namespace App\Http\Routes\Account\Requests;

use App\Http\Requests\BaseRequest;

class ChangeEmailRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'email' => 'required|unique:users',
            'currentPassword' => 'required'
        ];
    }
}
