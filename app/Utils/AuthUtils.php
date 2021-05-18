<?php


namespace App\Utils;


use Illuminate\Support\Facades\Auth;

class AuthUtils {
    public static function getUserId(){
        return Auth::user()->id;
    }

    public static function getVendorId(){
        return Auth::user()->vendor_id;
    }

    public static function getRole(){
        return Auth::user()->role;
    }
}