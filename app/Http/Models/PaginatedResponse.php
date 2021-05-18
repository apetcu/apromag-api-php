<?php
namespace App\Http\Models;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedResponse extends ResourceCollection
{
    private $pagination;

    public function __construct($resource)
    {

        $this->pagination = [
            'totalCount' => $resource->total(),
            'pageSize' => $resource->perPage(),
            'currentPage' => $resource->currentPage(),
            'lastPage' => $resource->lastPage()
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' => $this->pagination
        ];
    }
}
