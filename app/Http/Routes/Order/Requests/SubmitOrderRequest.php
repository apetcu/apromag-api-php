<?php


namespace App\Http\Routes\Order\Requests;


use App\Http\Requests\BaseRequest;

class SubmitOrderRequest extends BaseRequest {

    public function rules() {
        return [
            'email' => 'required|email',
            'fullName' => 'required|string',
            'location' => 'numeric',
            'vendorId' => 'numeric',
            'phone' => 'string',
            'shippingAddress' => 'string',
            'remarks' => 'string',
            'products' => 'filled',
            'products.*.name' => 'required|string',
            'products.*.price' => 'required|numeric',
            'products.*.quantity' => 'required|integer',
            'products.*.productId' => 'required|integer'
        ];
    }
}