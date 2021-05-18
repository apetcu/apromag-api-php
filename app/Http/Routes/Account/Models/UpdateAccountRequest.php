<?php

namespace App\Http\Routes\Account\Models;

use App\Http\Requests\BaseRequest;

class UpdateAccountRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'address' => 'string|min:3|max:220',
            'phone' => 'required|string|min:6|max:15',
        ];
    }
}
