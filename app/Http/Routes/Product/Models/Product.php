<?php

namespace App\Http\Routes\Product\Models;

use App\Http\Models\Currency;
use App\Http\Models\Image;
use App\Http\Routes\Vendor\Models\Vendor;
use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Product extends BaseModel {

    use Notifiable;

    protected $fillable = [
        'name', 'description', 'stock', 'unit', 'price', 'vendor_id' , 'category_id'
    ];
    

    protected $hidden = [
        'imageUrl',
    ];

    public function vendor() {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function images() {
        return $this->belongsToMany(Image::class,'product_images');
    }

    public static function fromEntity($entity) {
        return array(
            'id' => $entity->id,
            'name' => $entity->name,
            'categoryId' => $entity->category_id,
            'description' => $entity->description,
            'currency' => new Currency(),
            'stock' => $entity->stock,
            'unit' => $entity->unit,
            'price' => $entity->price,
            'images' => $entity->images,
            'status' => $entity->status,
            'vendor' => Vendor::fromEntity((object) $entity->vendor)
        );
    }
}
