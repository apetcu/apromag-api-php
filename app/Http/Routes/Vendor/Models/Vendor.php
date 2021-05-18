<?php

namespace App\Http\Routes\Vendor\Models;

use App\Http\Models\Image;
use App\Http\Routes\Order\Models\Order;
use App\Http\Routes\Product\Models\Product;
use App\Http\Routes\Shipping\Models\ShippingPreference;
use App\Http\Routes\User\Models\User;
use App\Models\BaseModel;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Vendor extends BaseModel {
    public $timestamps = true;

    protected $fillable = [
        'businessName',
        'location'
    ];

    protected $with = ['notifications', 'images', 'shippingPreferences']; //Eager load the relationship


    public $appends = ['url', 'certificateUrl', 'productsCount'];

    public function getUrlAttribute() {
        return $this->profilePicture ? Storage::disk('s3')->url($this->profilePicture) : '';
    }


    public function getCertificateUrlAttribute() {
        return $this->certificate ? Storage::disk('s3')->url($this->certificate) : '';
    }


    public function user() {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function products() {
        return $this->hasMany(Product::class, 'vendor_id');
    }

    public function images() {
        return $this->belongsToMany(Image::class, 'vendor_images')->orderBy('id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'vendor_id');
    }

    public function notifications() {
        return $this->hasMany(Order::class, 'vendor_id')->where('seenAt',  null);
    }

    public function shippingPreferences() {
        return $this->hasMany(ShippingPreference::class, 'vendor_id');
    }

    public function getNotificationCountAttribute()
    {
        return $this->notifications->count();
    }

    public function getProductsCountAttribute()
    {
        return $this->products->count();
    }


    public static function fromEntity($entity) {
        try {
            $shipping_preferences = $entity->shippingPreferences;
        } catch (Exception $e) {
            $shipping_preferences = [];
        }
        return array(
            'id' => $entity->id,
            'address' => $entity->address,
            'businessName' => $entity->businessName,
            'description' => $entity->description,
            'profilePicture' => $entity->url,
            'rating' => $entity->rating,
            'status' => $entity->status,
            'phone' => $entity->phone,
            'certificate' => $entity->certificateUrl,
            'productsListed' => $entity->productsCount,
            'images' => $entity->images,
            'ratingCount' => $entity->ratingCount,
            'freeShippingOver' => $entity->freeShippingOver,
            'minOrder' => $entity->minOrder,
            'shippingPreferences' => $shipping_preferences ? ShippingPreference::mapArrayToDto($shipping_preferences) : null,
            'shippingCost' => $entity->shippingCost,
            'shippingRemarks' => $entity->shippingRemarks
        );
    }
}
