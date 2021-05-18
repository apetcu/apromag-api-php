<?php

namespace App\Http\Routes\Category\Models;

use App\Http\Models\Currency;
use App\Http\Routes\Product\Models\Product;
use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Category extends BaseModel {

    use Notifiable;

    protected $fillable = [
        'name', 'description', 'parent_id'
    ];

    protected $appends = ['url', 'productCount'];

    public function getUrlAttribute() {
        return $this->imageUrl ? Storage::disk('s3')->url($this->imageUrl) : null;
    }

    public function getProductCountAttribute() {
        return intval($this->products()->count()) + intval($this->childProducts()->count());
    }

    public function children() {
        return $this->hasMany(Category::class, 'parent_id', 'id'); // the 'id' here probably isn't necessary, but just in case
    }

    public function products() {
        return $this->hasMany(Product::class, 'category_id', 'id'); // the 'id' here probably isn't necessary, but just in case
    }

    public function childProducts() {
        return $this->hasManyThrough(Product::class, Category::class,
            'parent_id', // Foreign key on the environments table...
            'category_id', // Foreign key on the deployments table...
            'id',
            'id');
    }

    public function parent() {
        return $this->belongsTo(Category::class, 'id', 'parent_id');
    }


    // https://laravel.com/docs/7.x/eloquent-resources
    public static function fromEntity($entity) {
        return array(
            'id' => $entity->id,
            'name' => $entity->name,
            'description' => $entity->description,
            'homepage' => $entity->homepage,
            'parentId' => $entity->parent_id,
            'imageUrl' => $entity->url,
            'productCount' => $entity->productCount,
            'children' => property_exists($entity, 'children') ? Category::mapArrayToDto($entity->children) : []
        );
    }
}
