<?php


namespace App\Http\Routes\Product\Requests;

use App\Http\Requests\BaseRequest;

class ModifyProductRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [];
//        return [
//            'name' => 'required|numeric',
//            'categoryId' => 'required|numeric',
//            'price' => 'required|numeric',
//            'unit' => 'required',
//            'stock' => 'required',
//            'description' => '',
//        ];
    }
}
