<?php

namespace App\Providers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Facades\Image;


class UploadedFileServiceProvider extends ServiceProvider {
    public function register() {
        UploadedFile::macro('manipulate', function ($callback) {
            return tap($this, function (UploadedFile $file) use ($callback) {
                $image = Image::make($file->getPathname());
                $callback($image);
                $image->save();
            });
        });
    }
    public function boot() {
        //
    }
}