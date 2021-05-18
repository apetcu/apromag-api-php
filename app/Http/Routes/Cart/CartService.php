<?php

namespace App\Http\Routes\Cart;

use App\Http\Routes\Cart\Models\TotalSummary;
use App\Http\Routes\Product\ProductRepository;
use App\Http\Routes\Vendor\VendorRepository;
use Illuminate\Support\Arr;

class CartService {
    private $productRepository;
    private $vendorRepository;

    public function __construct(ProductRepository $productRepository, VendorRepository $vendorRepository) {
        $this->productRepository = $productRepository;
        $this->vendorRepository = $vendorRepository;
    }

    public function getTotal($request) {
        $productIds = Arr::pluck($request,'id');
        $quantitiesList = Arr::pluck($request,'quantities');

        $quantityMappings = Array();
        foreach($request as $cartItem){
            $quantityMappings[$cartItem['id']] = $cartItem['quantity'];
        }

        
        return $this->getTotalByIdsAndQuantities($productIds, $quantityMappings, $quantitiesList);
    }

    public function getTotalByIdsAndQuantities($productIds, $quantityMappings, $quantitiesList) {
        $totalProductsPrice = 0;
        $shippingPrice = 0;

        $productDetailsList = $this->productRepository->findByIdList($productIds);
        
        foreach ($productDetailsList as $key => $product) {
            $totalProductsPrice += $product->price * $quantityMappings[$product->id];
        }

        $vendor = $this->vendorRepository->findById($productDetailsList[0]->vendor_id);
        if($vendor->freeShippingOver > $totalProductsPrice && $vendor->shippingCost){
            $shippingPrice = $vendor->shippingCost;
        }

        $totalSummary = new TotalSummary;
        $totalSummary->shippingPrice = $shippingPrice;
        $totalSummary->totalProductsPrice = $totalProductsPrice;
        $totalSummary->totalItems = array_sum($quantitiesList);
        $totalSummary->total = $totalSummary->shippingPrice + $totalSummary->totalProductsPrice;

        return $totalSummary;
    }
}