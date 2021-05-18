<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class BaseModel extends Authenticatable {
    public $timestamps = true;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';


    public static function fromEntity($entity) {
        return array();
    }

    public static function mapArrayToDto($array) {
        return array_map(function ($entity) {
            return static::fromEntity((object)$entity);
        }, is_array($array) ? $array : $array->toArray());
    }


    public static function boot() {
        parent::boot();

        self::creating(function ($model) {
            $model->createdAt = Carbon::now()->format('Y-m-d H:i:s');
        });

        self::updating(function ($model) {
            $model->updatedAt = Carbon::now()->format('Y-m-d H:i:s');
        });

        self::deleted(function ($file) {
            if ($file->path) {
                Storage::disk('s3')->delete($file->path);
            }
        });

    }

}