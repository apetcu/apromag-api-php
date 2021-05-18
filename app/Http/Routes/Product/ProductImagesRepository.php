<?php

namespace App\Http\Routes\Product;

use App\Http\Base\BaseRepository;
use App\Http\Routes\Product\Models\ProductImages;

class ProductImagesRepository extends BaseRepository {

    public function __construct(ProductImages $model) {
        parent::__construct($model);
    }

    public function findByImageIdAndProductId($imageId, $productId) {
        return $this->repository
            ->where('product_id', $productId)
            ->where('image_id', $imageId)
            ->with('image')
            ->get()->first();
    }
}