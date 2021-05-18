<?php

namespace App\Http\Routes\Page;

use App\Http\Base\BaseRepository;
use App\Http\Routes\Page\Models\Page;

class PageRepository extends BaseRepository {

    public function __construct(Page $model) {
        parent::__construct($model);
    }

}