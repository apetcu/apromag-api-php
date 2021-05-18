<?php

namespace App\Http\Routes\Order;


use App\Http\Base\BaseRepository;
use App\Http\Routes\Order\Models\OrderStatusHistory;

class OrderStatusHistoryRepository extends BaseRepository {
    public function __construct(OrderStatusHistory $model) {
        parent::__construct($model);
    }
    
    public function findByOrderId($id) {
        return $this->repository->where('order_id', $id)->get();
    }

}