<?php

namespace App\Http\Routes\Shipping;


use App\Http\Base\BaseRepository;
use App\Http\Routes\Shipping\Models\ShippingLocation;

class ShippingLocationRepository extends BaseRepository {
    public function __construct(ShippingLocation $shippingLocation) {
        parent::__construct($shippingLocation);
    }

}