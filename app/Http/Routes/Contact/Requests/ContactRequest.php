<?php

namespace App\Http\Routes\Contact\Requests;

use App\Http\Requests\BaseRequest;

class ContactRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string'
        ];
    }
}
