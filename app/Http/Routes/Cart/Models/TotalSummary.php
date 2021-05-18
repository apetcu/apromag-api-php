<?php


namespace App\Http\Routes\Cart\Models;


use App\Http\Models\Currency;

class TotalSummary {
    public $shippingPrice;
    public $totalItems;
    public $totalProductsPrice;
    public $total;
    public $currency;

    public function __construct() {
        $this->currency = new Currency();
    }
}