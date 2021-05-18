<?php

namespace App\Http\Routes\Page;

use App\Http\Routes\Category\Models\Category;
use App\Http\Routes\Page\Models\Page;
use App\Http\Routes\Product\Models\Product;
use App\Http\Routes\Product\ProductRepository;

class PageService {
    private $pageRepository;

    public function __construct(PageRepository $pageRepository) {
        $this->pageRepository = $pageRepository;
    }

    public function findAll() {
        return Page::mapArrayToDto($this->pageRepository->findAll());
    }

    public function findById($id) {
        return Page::fromEntity($this->pageRepository->findById($id));
    }

    public function update($id, $fields) {
        return $this->pageRepository->update($id, $fields);
    }
}