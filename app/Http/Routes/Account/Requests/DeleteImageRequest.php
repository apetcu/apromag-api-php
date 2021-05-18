<?php

namespace App\Http\Routes\Account\Requests;

use App\Http\Requests\BaseRequest;

class DeleteImageRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'id' => 'required|numeric'
        ];
    }
}
