<?php


namespace App\Http\Routes\Admin\Requests;

use App\Http\Requests\BaseRequest;

class SetProductStatusRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'status' => 'required|string',
        ];
    }
}
