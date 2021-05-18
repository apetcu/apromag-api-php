<?php

namespace App\Http\Routes\Shipping;

use App\Http\Controllers\Controller;
use App\Http\Routes\Shipping\Requests\CreateShippingLocation;
use App\Http\Routes\Shipping\Requests\UpdateShippingPreferencesRequest;

class ShippingController extends Controller {
    private $shippingService;

    public function __construct(ShippingService $shippingService) {
        $this->shippingService = $shippingService;
    }

    public function getById($id) {
        return response()->json($this->shippingService->findById($id));
    }

    public function getLocations() {
        return response()->json($this->shippingService->findLocations());
    }

    public function updatePreferences(UpdateShippingPreferencesRequest $request) {
        return response()->json($this->shippingService->updatePreferences($request));
    }


    public function create(CreateShippingLocation $request) {
        return response()->json($this->shippingService->create($request->toArray()));
    }

    public function update($id, CreateShippingLocation $request) {
        return response()->json($this->shippingService->update($id, $request->toArray()));
    }

    public function delete($id) {
        return response()->json($this->shippingService->delete($id));
    }

}
