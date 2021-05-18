<?php

namespace App\Http\Routes\Product;

use App\Http\Controllers\Controller;
use App\Http\Routes\Product\Requests\ModifyProductRequest;
use App\Utils\AuthUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller {
    private $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function getById($id) {
        return response()->json($this->productService->findById($id));
    }

    public function getAll() {
        $query = Input::get('searchQuery');
        $response = $query ? $this->productService->findByQuery($query) : $this->productService->findAll();
        return response()->json($response);
    }

    public function addProduct( ModifyProductRequest $request) {
        return response()->json($this->productService->addProduct($request));
    }


    public function deleteProductImage($productId, $imageId) {
        return $this->productService->deleteProductImage(AuthUtils::getVendorId(), $productId, $imageId);
    }

    public function deleteProduct($productId) {
        return $this->productService->deleteProduct(AuthUtils::getVendorId(), $productId);
    }

    public function updateProduct($id, ModifyProductRequest $request) {
        $images = $request->only('images');
        if ($images) {
            $this->productService->addProductImages($id, $request->only('images'));
        }
        $this->productService->updateProduct($id, $request->except('images'));

        response()->json([
            'success' => true
        ], Response::HTTP_OK);
    }
}
