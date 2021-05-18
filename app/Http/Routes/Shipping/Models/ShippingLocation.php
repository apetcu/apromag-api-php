<?php

namespace App\Http\Routes\Shipping\Models;

use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;

class ShippingLocation extends BaseModel {
    use Notifiable;

    protected $fillable = [
        'name', 'lat', 'lon'
    ];

    public static function fromEntity($entity) {
        return array(
            'id' => $entity->id,
            'name' => $entity->name,
            'lat' => $entity->lat,
            'lon' => $entity->lon
        );
    }
}
