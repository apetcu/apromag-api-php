<?php

namespace App\Http\Routes\Page\Models;

use App\Http\Models\Currency;
use App\Http\Routes\Product\Models\Product;
use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;

class Page extends BaseModel {
    protected $table = 'static_pages';

    use Notifiable;

    protected $fillable = [
        'title', 'content'
    ];

    // https://laravel.com/docs/7.x/eloquent-resources
    public static function fromEntity($entity) {
        return array(
            'id' => $entity->id,
            'title' => $entity->title,
            'content' => $entity->content
        );
    }
}
