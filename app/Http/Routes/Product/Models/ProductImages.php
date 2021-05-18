<?php

namespace App\Http\Routes\Product\Models;

use App\Http\Models\Currency;
use App\Http\Models\Image;
use App\Http\Routes\Vendor\Models\Vendor;
use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;

class ProductImages extends BaseModel {
    use Notifiable;

    protected $fillable = [
        'product_id', 'image_id'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public static function fromEntity($entity) {
        return array(
            'id' => $entity->id,
            'path' => $entity->path,
        );
    }
}
