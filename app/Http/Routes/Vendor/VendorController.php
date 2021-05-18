<?php

namespace App\Http\Routes\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Models\Image;
use App\Http\Routes\User\Requests\UpdateStatusRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorController extends Controller {
    private $vendorService;

    public function __construct(VendorService $vendorService) {
        $this->vendorService = $vendorService;
    }

    public function getAll(Request $request) {
        $locationId = $name = $request->query('locationId');
        return response()->json($this->vendorService->getActive($locationId));
    }

    public function getPopular() {
        return response()->json(['data' => $this->vendorService->getPopular()]);
    }
    
    public function getLatest() {
        return response()->json(['data' => $this->vendorService->getLatest()]);
    }

    public function getById($id) {
        return response()->json($this->vendorService->getById($id));
    }

    public function getProducts($id) {
        return response()->json($this->vendorService->getProducts($id));
    }

    public function setStatus($id, UpdateStatusRequest $request) {
        return response()->json($this->vendorService->updateVendorDetails($id, $request->only('status')));
    }


}
