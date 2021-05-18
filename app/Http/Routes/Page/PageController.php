<?php

namespace App\Http\Routes\Page;

use App\Http\Controllers\Controller;
use App\Http\Routes\Page\Models\UpdatePageRequest;

class PageController extends Controller {
    private $pageService;

    public function __construct(PageService $pageService) {
        $this->pageService = $pageService;
    }

    public function getById($id) {
        return response()->json($this->pageService->findById($id));
    }

    public function getAll() {
        return response()->json($this->pageService->findAll());
    }

    public function update(UpdatePageRequest $request, $id) {
        return response()->json($this->pageService->update($id, $request->only('title', 'content')));
    }
}
