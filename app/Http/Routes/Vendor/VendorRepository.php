<?php

namespace App\Http\Routes\Vendor;


use App\Http\Base\BaseRepository;
use App\Http\Routes\Vendor\Models\Vendor;

class VendorRepository extends BaseRepository {
    public function __construct(Vendor $vendor) {
        parent::__construct($vendor);
    }
    
    public function findActive() {
        return $this->repository
            ->where('status', 'ACTIVE')
            ->jsonPaginate([Vendor::class, 'fromEntity']);
    }
    
    public function findAll() {
        return $this->repository
            ->jsonPaginate([Vendor::class, 'fromEntity']);
    }

    public function findByQuery($query) {
        return $this->repository
            ->where('description', 'like', '%'.$query.'%')
            ->orWhere('address', 'like', '%'.$query.'%')
            ->orWhere('businessName', 'like', '%'.$query.'%')
            ->orWhere('phone', 'like', '%'.$query.'%')
            ->jsonPaginate([Vendor::class, 'fromEntity']);
    }

    public function findByLocationId($locationId) {
        return $this->repository
            ->where('status', 'ACTIVE')
            ->whereHas('shippingPreferences', function ($query) use ($locationId) {
                return $query->where('location_id', $locationId);
            })
            ->jsonPaginate([Vendor::class, 'fromEntity']);
    }

    public function findPopular() {
        return $this->repository->withCount('orders')->orderBy('orders_count', 'desc')->limit(6)->get();
    }
    
    public function findLatest() {
        return $this->repository->where('status', 'ACTIVE')->orderBy('createdAt', 'desc')->limit(8)->get();
    }

    public function updateProfilePicture($vendorId, $profilePicture) {
        return $this->repository
            ->where('id', $vendorId)
            ->update(['profilePicture' => $profilePicture]);
    }

}