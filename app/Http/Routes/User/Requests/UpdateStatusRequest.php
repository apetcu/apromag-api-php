<?php

namespace App\Http\Routes\User\Requests;

use App\Http\Requests\BaseRequest;

class UpdateStatusRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'status' => 'in:DISABLED,ACTIVE'
        ];
    }
}
