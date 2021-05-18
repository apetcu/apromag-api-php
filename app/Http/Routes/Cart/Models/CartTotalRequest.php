<?php

namespace App\Http\Routes\Cart\Models;

use App\Http\Requests\BaseRequest;

class CartTotalRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'row.*.id' => 'required|number',
            'row.*.quantity' => 'required|number'
        ];
    }
}
