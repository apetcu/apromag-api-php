<?php

namespace App\Http\Routes\Shipping;

use App\Http\Routes\Account\AccountService;
use App\Http\Routes\Shipping\Models\ShippingLocation;
use App\Http\Routes\Shipping\Requests\UpdateShippingPreferencesRequest;
use App\Http\Routes\User\Models\User;
use App\Http\Routes\User\UserService;
use App\Http\Routes\Vendor\VendorService;
use App\Utils\AuthUtils;
use Illuminate\Support\Facades\Cache;

class ShippingService {
    private $shippingPreferenceRepository;
    private $shippingLocationRepository;
    private $accountService;
    private $vendorService;

    public function __construct(ShippingPreferenceRepository $shippingPreferenceRepository, ShippingLocationRepository $shippingLocationRepository, VendorService $vendorService, AccountService $accountService) {
        $this->shippingLocationRepository = $shippingLocationRepository;
        $this->shippingPreferenceRepository = $shippingPreferenceRepository;
        $this->vendorService = $vendorService;
        $this->accountService = $accountService;
    }

    public function findLocations() {
        return Cache::remember('shipping.locations', config('cache.expiry_time'), function () {
            return ShippingLocation::mapArrayToDto($this->shippingLocationRepository->findAll());
        });
    }

    public function findById($id) {
        return $this->shippingLocationRepository->findById($id);
    }

    public function updatePreferences(UpdateShippingPreferencesRequest $shippingPreferences) {
        $vendor_id = AuthUtils::getVendorId();

        $this->vendorService->updateVendorDetails($vendor_id, [
            'minOrder' => $shippingPreferences->minOrder,
            'shippingCost' => $shippingPreferences->shippingCost,
            'shippingRemarks' => $shippingPreferences->shippingRemarks,
            'freeShippingOver' => $shippingPreferences->freeShippingOver,
        ]);

        $preferences = array_map(function ($shippingPreference) use ($vendor_id) {
            return ['vendor_id' => $vendor_id, 'location_id' => $shippingPreference['locationId']];
        }, $shippingPreferences->input('locations'));
        $this->shippingPreferenceRepository->clearVendorPreferences($vendor_id);
        $this->shippingPreferenceRepository->insert($preferences);

        return $this->accountService->getLoggedInUser();
    }


    public function create($shippingLocation) {
        return $this->shippingLocationRepository->insert($shippingLocation);
    }

    public function update($id, $categoryRequest) {
        return $this->shippingLocationRepository->update($id, $categoryRequest);
    }

    public function delete($id) {
        return $this->shippingLocationRepository->delete($id);
    }
}