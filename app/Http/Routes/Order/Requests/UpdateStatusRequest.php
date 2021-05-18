<?php


namespace App\Http\Routes\Order\Requests;


use App\Http\Requests\BaseRequest;

class UpdateStatusRequest extends BaseRequest {

    public function rules() {
        return [
            'status' => 'in:SUBMITTED,CANCELED,SHIPPED,IN_PROGRESS,COMPLETED',
            'remarks' => 'string'
        ];
    }
}