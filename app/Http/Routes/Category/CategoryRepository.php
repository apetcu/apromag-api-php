<?php

namespace App\Http\Routes\Category;

use App\Http\Base\BaseRepository;
use App\Http\Routes\Category\Models\Category;

class CategoryRepository extends BaseRepository {

    public function __construct(Category $category) {
        parent::__construct($category);
    }

    public function findAll() {
        return $this->repository->whereNull('parent_id')
            ->with('children')
            ->get();
    }

    public function findById($id) {
        return $this->repository->where('id', $id)
            ->with('children')
            ->get()->first();
    }

}