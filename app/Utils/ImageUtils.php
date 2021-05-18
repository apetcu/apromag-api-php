<?php


namespace App\Utils;


use Intervention\Image\Facades\Image;

class ImageUtils {
    public static function resize($image, $width, $height){
        $img = Image::make($image->getPathname());
        $img->fit($width, $height, function ($constraint) {
            $constraint->upsize();
        });
        $img->save();
        return $img;
    }
}