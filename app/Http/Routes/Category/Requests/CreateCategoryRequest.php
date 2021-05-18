<?php

namespace App\Http\Routes\Category\Requests;

use App\Http\Requests\BaseRequest;

class CreateCategoryRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [];
//        return [
//            'name' => 'required',
//            'parentId' => 'required',
//            'description' => 'required',
//        ];
    }
}
