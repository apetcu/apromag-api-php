<?php

namespace App\Http\Routes\Page\Models;

use App\Http\Requests\BaseRequest;

class UpdatePageRequest extends BaseRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'title' => 'required|string',
            'content' => 'required|string'
        ];
    }
}
