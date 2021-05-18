<?php

namespace App\Http\Routes\Category;

use App\Http\Models\Image;
use App\Http\Routes\Category\Models\Category;
use App\Http\Routes\Product\Models\Product;
use App\Http\Routes\Product\ProductRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CategoryService {
    private $categoryRepository;
    private $productRepository;
    private $image;

    public function __construct(CategoryRepository $categoryRepository, Image $image,  ProductRepository $productRepository) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->image = $image;
    }

    public function findAll() {
        return Cache::remember('categories', config('cache.expiry_time'), function () {
            return Category::mapArrayToDto($this->categoryRepository->findAll());
        });
    }

    public function findById($id) {
        return Category::fromEntity($this->categoryRepository->findById($id));
    }

    public function findProducts($id) {
        return $this->productRepository->findByCategoryId($id);
    }

    public function create($categoryRequest) {
        return $this->createOrUpdate(null, $categoryRequest);
    }

    public function update($id, $categoryRequest) {
        return $this->createOrUpdate($id, $categoryRequest);
    }
    
    public function createOrUpdate($id, $categoryRequest){
        if(array_key_exists('images', $categoryRequest) && $categoryRequest['images'][0]) {
            $image = $categoryRequest['images'][0];
            $path = Storage::disk('s3')->put('images/categories', $image->manipulate(function (\Intervention\Image\Image $image) {
                $image->resize(500, 500, function($constraint) {
                    $constraint->aspectRatio(1);
                });
            }));
            unset($categoryRequest['images']);
            $categoryRequest['imageUrl'] = $path;
        }
        if($categoryRequest['parentId'] != 'null') {
            $categoryRequest['parent_id'] = $categoryRequest['parentId'];
        }
        if($categoryRequest['description'] == 'null') {
            unset($categoryRequest['description']);
        }
        unset($categoryRequest['parentId']);
        logger ($categoryRequest);
        if($id) {
            return $this->categoryRepository->update($id, $categoryRequest);
        } else {
            return $this->categoryRepository->create($categoryRequest);
        }
    }


    public function delete($id) {
        return $this->categoryRepository->delete($id);
    }

}