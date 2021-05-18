<?php

namespace App\Http\Models;

use App\Models\BaseModel;
use Illuminate\Support\Facades\Storage;

class Image extends BaseModel {
    protected $fillable = [
        'path', 'size'
    ];

    public $appends = ['url', 'size_in_kb'];
    public $hidden = ['pivot', 'createdAt', 'updatedAt', 'size'];

    public function getUrlAttribute() {
        return Storage::disk('s3')->url($this->path);
    }

    /*, 'uploaded_time'
    public function getUploadedTimeAttribute() {
        return $this->createdAt->diffForHumans();
    }
    */

    public function getSizeInKbAttribute() {
        return round($this->size / 1024, 2);
    }

}