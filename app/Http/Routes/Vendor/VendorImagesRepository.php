<?php

namespace App\Http\Routes\Vendor;

use App\Http\Base\BaseRepository;
use App\Http\Routes\Vendor\Models\VendorImages;

class VendorImagesRepository extends BaseRepository {

    public function __construct(VendorImages $model) {
        parent::__construct($model);
    }

    public function findAllByVendorId($vendorId) {
        return $this->repository
            ->where('vendor_id', $vendorId)
            ->with('image')
            ->get();
    }

    public function findByImageIdAndVendorId($vendorId, $imageId) {
        return $this->repository
            ->where('vendor_id', $vendorId)
            ->where('image_id', $imageId)
            ->with('image')
            ->get()->first();
    }
}