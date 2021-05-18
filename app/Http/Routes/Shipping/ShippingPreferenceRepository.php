<?php

namespace App\Http\Routes\Shipping;


use App\Http\Base\BaseRepository;
use App\Http\Routes\Shipping\Models\ShippingLocation;
use App\Http\Routes\Shipping\Models\ShippingPreference;
use App\Http\Routes\User\Models\User;
use App\Http\Routes\Vendor\Models\Vendor;

class ShippingPreferenceRepository extends BaseRepository {
    public function __construct(ShippingPreference $shippingPreference) {
        parent::__construct($shippingPreference);
    }

    public function clearVendorPreferences($vendor_id){
        $this->repository->where('vendor_id', $vendor_id)->delete();
    }

}