<?php

namespace App\Http\Routes\Product;

use App\Http\Models\Image;
use App\Http\Routes\Product\Models\Product;
use App\Http\Routes\Product\Requests\ModifyProductRequest;
use App\Utils\AuthUtils;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductService {
    private $productRepository;
    private $productImagesRepository;
    private $image;

    public function __construct(ProductRepository $productRepository, Image $image, ProductImagesRepository $productImagesRepository) {
        $this->productRepository = $productRepository;
        $this->productImagesRepository = $productImagesRepository;
        $this->image = $image;
    }

    public function findAll($hideDisabled = true) {
        return $this->productRepository->findAll($hideDisabled);
    }

    public function findByQuery($query, $hideDisabled = true) {
        return $this->productRepository->findByQuery($query, $hideDisabled);
    }

    public function addProduct(ModifyProductRequest $request) {
        $product = new Product();
        $product->fill($request->except('images'));
        $product->vendor_id = AuthUtils::getVendorId();

        $id = $this->productRepository->save($product);

        $images = $request->only('images');
        if ($images) {
            $this->addProductImages($id, $images);
        }
        return true;
    }

    public function updateProduct($id, $attributes) {
        return $this->productRepository->updateByIdAndVendorId($id, AuthUtils::getVendorId(), $attributes);
    }

    public function addProductImages($id, $request) {
        foreach ($request['images'] as $image) {
            $path = Storage::disk('s3')->put('images/products', $image->manipulate(function (\Intervention\Image\Image $image) {
                $image->resize(1000, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }));
            $image_id = $this->image->create(['size' => $image->getClientSize(), 'path' => $path])->id;
            $this->productImagesRepository->create(['product_id' => $id, 'image_id' => $image_id]);
        }
    }

    public function deleteProductImage($vendorId, $productId, $imageId) {
        $foundProduct = $this->productRepository->findByIdAndVendorId($productId, $vendorId);

        if ($foundProduct) {
            $productImage = $this->productImagesRepository->findByImageIdAndProductId($imageId, $productId);
            // Storage::disk('s3')->delete($productImage->toArray()['image']['path']);
            $productImage->delete();

            return response()->json([
                'success' => true
            ], Response::HTTP_OK);
        }


        return response()->json([], Response::HTTP_FORBIDDEN);
    }

    public function deleteProduct($vendorId, $productId) {
        $foundProduct = $this->productRepository->findByIdAndVendorId($productId, $vendorId);

        if ($foundProduct) {
            $foundProduct->images()->delete();
            $foundProduct->delete();
            // Todo: delete related records + imgs from aws
            return response()->json([
                'success' => true
            ], Response::HTTP_OK);
        }

        return response()->json([], Response::HTTP_FORBIDDEN);
    }

    public function findById($id) {
        return Product::fromEntity($this->productRepository->findById($id));
    }

    public function setStatus($id, $status) {
        return $this->productRepository->update($id, array('status' => $status));
    }

    public function findVendorProducts($vendorId) {
        return $this->productRepository->findVendorProducts($vendorId);
    }
}