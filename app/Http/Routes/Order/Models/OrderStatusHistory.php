<?php

namespace App\Http\Routes\Order\Models;

use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;

class OrderStatusHistory extends BaseModel {
    use Notifiable;
    protected $table = 'order_status_history';

    protected $fillable = [
        'previous', 'next', 'order_id', 'remarks'
    ];

    protected $hidden = [
        'id', 'order_id'
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }

    public static function fromEntity($entity) {
        return array(
            'previous' => $entity->previous,
            'next' => $entity->next,
            'remarks' => $entity->remarks,
            'createdAt' => $entity->createdAt
        );
    }
}
