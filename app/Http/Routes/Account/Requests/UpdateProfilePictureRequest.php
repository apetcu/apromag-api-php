<?php

namespace App\Http\Routes\Account\Requests;

use App\Http\Requests\BaseRequest;

class UpdateProfilePictureRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'profilePicture' => 'mimes:jpeg,bmp,png,gif,jpg'
        ];
    }
}
