<?php

namespace App\Http\Routes\Account\Requests;

use App\Http\Requests\BaseRequest;

class AddVendorImagesRequest extends BaseRequest {

    public function rules() {
        return [
            'images.*' => 'mimes:jpeg,bmp,png,gif,jpg'
        ];
    }
}
