<?php

namespace App\Http\Routes\Account\Requests;

use App\Http\Requests\BaseRequest;

class ChangePasswordRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'password' => 'required',
            'currentPassword' => 'required'
        ];
    }
}
