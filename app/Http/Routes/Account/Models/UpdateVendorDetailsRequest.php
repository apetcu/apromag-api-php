<?php

namespace App\Http\Routes\Account\Models;

use App\Http\Requests\BaseRequest;

class UpdateVendorDetailsRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'businessName' => 'required|string',
            'address' => 'required|string',
            'certificate' => 'nullable|sometimes|mimes:jpeg,bmp,png,gif,jpg,pdf|max:10000',
            'phone' => 'required|string',
            'description' => 'string',
        ];
    }
}