<?php


namespace App\Http\Routes\Shipping\Requests;


use App\Http\Requests\BaseRequest;

class CreateShippingLocation extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'lat' => '',
            'lon' => '',
            'name' => 'required',
        ];
    }
}
