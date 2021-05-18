<?php

namespace App\Http\Routes\Vendor\Models;

use App\Http\Models\Image;
use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;

class VendorImages extends BaseModel {
    use Notifiable;

    protected $fillable = [
        'vendor_id', 'image_id'
    ];

    public function vendor() {
        return $this->belongsTo(Vendor::class, 'id', 'vendor_id');
    }

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
}
