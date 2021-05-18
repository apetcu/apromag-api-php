<?php


namespace App\Http\Routes\Shipping\Requests;


use App\Http\Requests\BaseRequest;

class UpdateShippingPreferencesRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'freeShippingOver' => 'nullable|numeric',
            'shippingCost' => 'required|numeric',
            'minOrder' => 'required|numeric',
            'shippingRemarks' => '',
            'locations' => '',
        ];
    }
}
