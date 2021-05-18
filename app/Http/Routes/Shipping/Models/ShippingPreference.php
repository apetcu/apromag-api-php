<?php

namespace App\Http\Routes\Shipping\Models;

use App\Http\Routes\Vendor\Models\Vendor;
use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;

class ShippingPreference extends BaseModel {
    use Notifiable;

    protected $fillable = [
        'vendor_id', 'location_id'
    ];

    public function vendor() {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function shippingLocation() {
        return $this->hasOne(ShippingLocation::class, 'id', 'location_id');
    }

    public static function fromEntity($entity) {
        return array(
            'name' => $entity->location_id,
            'locationId' => $entity->location_id
        );
    }
}
