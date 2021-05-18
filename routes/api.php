<?php

use Illuminate\Support\Facades\Route;

require_once base_path('app/Http/Routes/Category/CategoryRoutes.php');
require_once base_path('app/Http/Routes/Page/PageRoutes.php');
require_once base_path('app/Http/Routes/User/UserRoutes.php');
require_once base_path('app/Http/Routes/Auth/AuthRoutes.php');
require_once base_path('app/Http/Routes/Account/AccountRoutes.php');
require_once base_path('app/Http/Routes/Admin/AdminRoutes.php');
require_once base_path('app/Http/Routes/Vendor/VendorRoutes.php');
require_once base_path('app/Http/Routes/Cart/CartRoutes.php');
require_once base_path('app/Http/Routes/Product/ProductRoutes.php');
require_once base_path('app/Http/Routes/Shipping/ShippingRoutes.php');
require_once base_path('app/Http/Routes/Order/OrderRoutes.php');
require_once base_path('app/Http/Routes/Social/SocialRoutes.php');
require_once base_path('app/Http/Routes/Contact/ContactRoutes.php');

Route::fallback(function(){
    return response()->json([
        'message' => 'Route or method not found'], 404);
});