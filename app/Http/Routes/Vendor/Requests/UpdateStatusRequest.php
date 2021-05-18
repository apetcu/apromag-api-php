<?php

namespace App\Http\Routes\Vendor\Requests;

use App\Http\Requests\BaseRequest;

class UpdateStatusRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'status' => 'in:PENDING,DISABLED,ACTIVE'
        ];
    }
}
