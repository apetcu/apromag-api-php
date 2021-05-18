<?php

namespace App\Http\Routes\Order\Models;

use App\Http\Models\Currency;
use App\Http\Routes\Product\Models\Product;
use App\Http\Routes\Vendor\Models\Vendor;
use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;

class OrderProduct extends BaseModel {
    use Notifiable;

    protected $fillable = [
        'customer_id', 'vendor_id', 'product_id', 'name', 'price', 'quantity'
    ];

    protected $hidden = [
        'id', 'customer_id', 'vendor_id', 'createdAt', 'updatedAt', 'order_id'
    ];

    public function order() {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public static function fromEntity($entity) {
        return array(
            'name' => $entity->name,
            'price' => $entity->price,
            'quantity' => $entity->quantity,
            'currency' => new Currency(),
            'product_id' => $entity->product_id
        );
    }
}
