<?php

namespace App\Http\Routes\Order\Models;

use App\Http\Models\Currency;
use App\Http\Routes\Product\Models\Product;
use App\Http\Routes\User\Models\User;
use App\Http\Routes\Vendor\Models\Vendor;
use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Order extends BaseModel {
    use Notifiable;

    protected $fillable = [
        'shippingAddress', 'phone', 'email', 'fullName', 'status', 'subtotal', 'shippingPrice', 'remarks', 'vendorRemarks',
    ];

    protected $with = ['products']; //Eager load the relationship


    protected $hidden = [
        'id', 'customer_id', 'vendor_id'
    ];

    public function vendor() {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function customer() {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    public function products() {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public static function fromEntity($entity) {
        return array(
            'id' => $entity->id,
            'customerId' => $entity->customer_id,
            'vendorId' => $entity->vendor_id,
            'shippingAddress' => $entity->shippingAddress,
            'fullName' => $entity->fullName,
            'status' => $entity->status,
            'remarks' => $entity->remarks,
            'vendorRemarks' => $entity->vendorRemarks,
            'shippingPrice' => $entity->shipping_price,
            'total' => $entity->total,
            'subTotal' => $entity->sub_total,
            'seenAt' => $entity->seenAt,
            'phone' => $entity->phone,
            'currency' => new Currency(),
            'email' => $entity->email,
            'createdAt' => $entity->createdAt,
            'products' => OrderProduct::mapArrayToDto($entity->products)
        );
    }

}
