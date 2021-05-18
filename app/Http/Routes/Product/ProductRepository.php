<?php

namespace App\Http\Routes\Product;

use App\Http\Base\BaseRepository;
use App\Http\Routes\Category\Models\Category;
use App\Http\Routes\Order\Models\Order;
use App\Http\Routes\Product\Models\Product as Product;

class ProductRepository extends BaseRepository {

    public function __construct(Product $product) {
        parent::__construct($product);
    }


    public function save($product) {
        $product->save();
        return $product->id;
    }


    public function findByQuery($query, $hideDisabled = true) {
        return $this->repository->with('vendor')
            ->where('description', 'like', '%'.$query.'%')
            ->orWhere('name', 'like', '%'.$query.'%')
            ->when($hideDisabled, function($query) {
                return $query->where('status', '!=', 'DISABLED');
            })
            ->jsonPaginate([Product::class, 'fromEntity']);
    }

    public function findAll($hideDisabled = true) {
        return Product::with('vendor')
            ->with('images')
            ->when($hideDisabled, function($query) {
                return $query->where('status', '!=', 'DISABLED');
            })
            ->jsonPaginate([Product::class, 'fromEntity']);
    }

    public function updateByIdAndVendorId($id, $vendorId, $attributes) {
        return $this->repository
            ->where('id', $id)
            ->where('vendor_id', $vendorId)
            ->update($attributes);
    }

    public function findByVendorId($vendorId) {
        return $this->repository
            ->where('vendor_id', $vendorId)
            ->with('vendor', 'vendor.images')
            ->with('images')
            ->jsonPaginate([Product::class, 'fromEntity']);
    }

    public function findByIdAndVendorId($id, $vendorId) {
        return $this->repository
            ->where('id', $id)
            ->where('vendor_id', $vendorId)
            ->get()->first();
    }

    public function findByIdList($idList) {
        return $this->repository
            ->whereIn('id', $idList)
            ->get();
    }

    public function findByCategoryId($id) {
        $categoryIds = Category::where('parent_id', $parentId = Category::where('id', $id)
            ->value('id'))
            ->pluck('id')
            ->push($parentId)
            ->all();
        
        return $this->repository
            ->whereIn('category_id', $categoryIds)
            ->with('images')
            ->without('vendor')
            ->jsonPaginate([Product::class, 'fromEntity']);
    }

    // Find vendor specific products
    public function findVendorProducts($vendorId) {
        return $this->repository
            ->where('vendor_id', $vendorId)
            ->with('vendor', 'vendor.images')
            ->with('images')
            ->jsonPaginate([Product::class, 'fromEntity']);
    }

}