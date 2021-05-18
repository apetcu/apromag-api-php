<?php

namespace App\Http\Routes\Admin;

use App\Http\Controllers\Controller;
use App\Http\Routes\Admin\Requests\SetProductStatusRequest;
use App\Http\Routes\Product\ProductService;
use App\Http\Routes\Vendor\VendorService;
use App\Utils\AuthUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller {
    private $adminService;
    private $productService;
    private $vendorService;

    public function __construct(AdminService $adminService, ProductService $productService, VendorService $vendorService) {
        $this->adminService = $adminService;
        $this->productService = $productService;
        $this->vendorService = $vendorService;
    }

    public function getStatistics() {
        return response()->json($this->adminService->getStatistics());
    }
    
    public function getAnalytics() {
        return response()->json($this->adminService->getAnalytics());
    }


    public function getProducts() {
        $query = Input::get('searchQuery');
        $response = $query ? $this->productService->findByQuery($query, false) : $this->productService->findAll(false);
        return response()->json($response);
    }
    
    public function getProductById($id) {
            return response()->json($this->productService->findById($id));
    }
    
    public function setProductStatus($id, SetProductStatusRequest $request) {
            return response()->json($this->productService->setStatus($id, $request->only('status')['status']));
    }

    public function getVendors() {
        $query = Input::get('searchQuery');
        $response = $query ? $this->vendorService->getAllByQuery($query) : $this->vendorService->getAll();
        return response()->json($response);
    }
    
    public function getVendorById($id) {
        return response()->json($this->vendorService->getById($id));
    }

}
