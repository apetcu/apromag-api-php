<?php

namespace App\Http\Routes\Category;

use App\Http\Controllers\Controller;
use App\Http\Routes\Category\Requests\CreateCategoryRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class CategoryController extends Controller {
    private $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function getById($id) {
        return response()->json($this->categoryService->findById($id));
    }

    public function getAll() {
        return response()->json($this->categoryService->findAll());
    }

    public function getProducts($id) {
        return response()->json($this->categoryService->findProducts($id));
    }

    public function create(CreateCategoryRequest $request) {
        return response()->json($this->categoryService->create($request->toArray()));
    }

    public function update($id, CreateCategoryRequest $request) {
        return response()->json($this->categoryService->update($id, $request->toArray()));
    }

    public function delete($id) {
        return response()->json($this->categoryService->delete($id));
    }
}
