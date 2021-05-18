<?php

namespace App\Http\Routes\User\Requests;

use App\Http\Requests\BaseRequest;

class UpdateUserRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'address' => 'string|min:3|max:220',
            'phone' => 'required|string|max:15',
        ];
    }
}
