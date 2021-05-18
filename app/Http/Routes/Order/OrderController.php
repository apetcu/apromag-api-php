<?php

namespace App\Http\Routes\Order;

use App\Http\Controllers\Controller;
use App\Http\Routes\Order\Requests\SubmitOrderRequest;
use App\Http\Routes\Order\Requests\UpdateStatusRequest;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller {
    private $orderService;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function getById($id) {
        return response()->json($this->orderService->findById($id));
    }
    
    public function getStatusHistory($id) {
        return response()->json($this->orderService->getStatusHistory($id));
    }

    public function getAll() {
        return response()->json($this->orderService->findAll());
    }

    public function save(SubmitOrderRequest $request) {
        return response()->json($this->orderService->save($request));
    }

    public function updateStatus($id, UpdateStatusRequest $request) {
        return response()->json($this->orderService->updateStatus($id, $request->only(['status', 'vendorRemarks'])), Response::HTTP_OK);
    }

    public function sendTestEmail() {
        return $this->orderService->sendTestEmail();
    }
}
