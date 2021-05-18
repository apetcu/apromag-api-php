<?php

namespace App\Http\Routes\Order;


use App\Http\Base\BaseRepository;
use App\Http\Routes\Order\Models\Order;

class OrderRepository extends BaseRepository {
    public function __construct(Order $model) {
        parent::__construct($model);
    }

    public function findAll() {
        return $this->repository->jsonPaginate([Order::class, 'fromEntity']);
    }
    
    
    public function findByQuery($query) {
        return $this->repository->with('vendor')
            ->where('id', 'like', '%'.$query.'%')
            ->where('email', 'like', '%'.$query.'%')
            ->orWhere('fullName', 'like', '%'.$query.'%')
            ->orWhere('phone', 'like', '%'.$query.'%')
            ->orWhere('status', 'like', '%'.$query.'%')
            ->jsonPaginate([Order::class, 'fromEntity']);
    }

    public function findAllByCustomerId($id) {
        return $this->repository
            ->where('customer_id', $id)
            ->jsonPaginate([Order::class, 'fromEntity']);
    }

    public function findAllByVendorIdAndStatus($id, $status) {
        return $this->repository
            ->where('vendor_id', $id)
            ->when($status, function($query) use($status) {
                return $query->where('status', '=', $status);
            })
            ->jsonPaginate([Order::class, 'fromEntity']);
    }


    public function findById($id) {
        return $this->repository->where('id', $id)
            ->first();
    }

    public function findByIdAndCustomerId($id, $customerId) {
        return $this->repository->where('id', $id)
            ->where('customer_id', $customerId)
            ->first();
    }

    public function findByIdAndVendorId($id, $vendorId) {
        return $this->repository->where('id', $id)
            ->where('vendor_id', $vendorId)
            ->first();
    }

}