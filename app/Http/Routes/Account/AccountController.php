<?php

namespace App\Http\Routes\Account;

use App\Http\Controllers\Controller;
use App\Http\Routes\Account\Models\UpdateAccountRequest;
use App\Http\Routes\Account\Models\UpdateVendorDetailsRequest;
use App\Http\Routes\Account\Requests\AddVendorImagesRequest;
use App\Http\Routes\Account\Requests\ChangeEmailRequest;
use App\Http\Routes\Account\Requests\ChangePasswordRequest;
use App\Http\Routes\Account\Requests\DeleteImageRequest;
use App\Http\Routes\Account\Requests\UpdateProfilePictureRequest;
use App\Http\Routes\Order\OrderService;
use App\Http\Routes\Product\ProductService;
use App\Http\Routes\Product\Requests\ModifyProductRequest;
use App\Http\Routes\User\Models\User;
use App\Utils\AuthUtils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\JWTAuth;

class AccountController extends Controller {
    private $accountService;
    private $orderService;
    private $productService;

    public function __construct(AccountService $accountService, OrderService $orderService, ProductService $productService) {
        $this->accountService = $accountService;
        $this->productService = $productService;
        $this->orderService = $orderService;
    }

    public function details() {
        return response()->json($this->accountService->getLoggedInUser());
    }

    public function updateDetails(UpdateAccountRequest $request) {
        $this->accountService->updateUserDetails($request->only('address', 'firstName', 'lastName', 'phone'));
        return $this->details();
    }

    public function updateVendorDetails(UpdateVendorDetailsRequest $request) {
        $this->accountService->updateVendorDetails($request);
        return $this->details();
    }

    public function getOrderSummary() {
        return response()->json($this->orderService->getVendorOrderSummary(AuthUtils::getVendorId()));
    }

    public function updateProfilePicture(UpdateProfilePictureRequest $request) {
        return response()->json($this->accountService->updateProfilePicture($request->only('profilePicture')));
    }

    public function addVendorImages(AddVendorImagesRequest $request) {
        return response()->json($this->accountService->uploadVendorImages($request->only('images')));
    }

    public function deleteImage(DeleteImageRequest $request) {
        return response()->json($this->accountService->deleteImage($request->only('id')));
    }
    
    public function getVendorProducts() {
        return response()->json($this->productService->findVendorProducts(AuthUtils::getVendorId()));
    }    
    
    public function getVendorOrders() {
        return response()->json($this->orderService->findAll());
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

    /**
     * Customer routes
     */
    public function getCustomerOrders() {
        return response()->json($this->orderService->findOrdersByCustomerId(AuthUtils::getUserId()));
    }

    public function getCustomerOrder($id) {
        return response()->json($this->orderService->findByIdAndCustomerId($id));
    }

    public function changePassword(ChangePasswordRequest $request) {
        return $this->accountService->changePassword($request->only('password', 'currentPassword'));
    }
    public function changeEmail(ChangeEmailRequest $request) {
        return $this->accountService->changeEmail($request->only('email', 'currentPassword'));
    }
}
