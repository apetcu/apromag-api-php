<?php

namespace App\Http\Routes\Cart;

use App\Http\Controllers\Controller;
use App\Http\Routes\Cart\Models\CartTotalRequest;

class CartController extends Controller {
    private $cartService;

    public function __construct(CartService $cartService) {
        $this->cartService = $cartService;
    }

    public function total(CartTotalRequest $request) {
        return response()->json($this->cartService->getTotal($request->toArray()));
    }

}
