<?php

namespace App\Http\Routes\Order;

use App\Http\Models\Currency;
use App\Http\Routes\Cart\CartService;
use App\Http\Routes\Order\Mail\OrderCreatedMail;
use App\Http\Routes\Order\Mail\OrderStatusChangeMail;
use App\Http\Routes\Order\Models\Order;
use App\Http\Routes\Order\Models\OrderProduct;
use App\Http\Routes\Order\Models\OrderStatusHistory;
use App\Http\Routes\Order\Requests\SubmitOrderRequest;
use App\Http\Routes\User\UserRepository;
use App\Http\Routes\Vendor\VendorRepository;
use App\Utils\AuthUtils;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class OrderService {
    private $orderRepository;
    private $userRepository;
    private $vendorRepository;
    private $orderStatusHistoryRepository;
    private $cartService;

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository, VendorRepository $vendorRepository, CartService $cartService, OrderStatusHistoryRepository $orderStatusHistoryRepository) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->vendorRepository = $vendorRepository;
        $this->cartService = $cartService;
        $this->orderStatusHistoryRepository = $orderStatusHistoryRepository;
    }
    
    public function getStatusHistory($id) {
        if(AuthUtils::getRole() === 'VENDOR') {
            $order = $this->orderRepository->findByIdAndVendorId($id, AuthUtils::getVendorId());
        } else {
            $order = $this->orderRepository->findByIdAndCustomerId($id, AuthUtils::getUserId());
        }
        
        if($order){
            return OrderStatusHistory::mapArrayToDto($this->orderStatusHistoryRepository->findByOrderId($order->id));
        }
        
        return null;
    }

    public function updateStatus($id, $request) {
        $order = $this->orderRepository->findByIdAndVendorId($id, AuthUtils::getVendorId());
        $vendor = $this->vendorRepository->findById(AuthUtils::getVendorId());
        $this->orderRepository->update($order->id, $request);

        $orderStatusHistory = new OrderStatusHistory();
        $orderStatusHistory->previous = $order->status;
        $orderStatusHistory->next = $request['status'];
        $orderStatusHistory->order_id = $id;
        $orderStatusHistory->remarks = $request['vendorRemarks'];
        
        $orderStatusHistory->save();
        
        Mail::to($order->email)
            ->send(new OrderStatusChangeMail($order, $vendor, $request['status'], $request['vendorRemarks']));
        
        return ['status' => $request['status']];
    }

    public function findAll() {
        $customerId = Input::get('customerId');
        $vendorId = Input::get('customerId');
        $status = Input::get('status');

        switch (AuthUtils::getRole()) {
            case 'ADMIN':
                if ($customerId) {
                    return $this->orderRepository->findAllByCustomerId($customerId);
                }
                if ($vendorId) {
                    return $this->orderRepository->findAllByVendorIdAndStatus($customerId, null);
                }
                $query = Input::get('searchQuery');
                return $query ? $this->orderRepository->findByQuery($query) : $this->orderRepository->findAll();
            case 'VENDOR':
                return $this->orderRepository->findAllByVendorIdAndStatus(AuthUtils::getVendorId(), $status);
                break;
        }
        return null;
    }

    public function findById($id) {
        switch (AuthUtils::getRole()) {
            case 'ADMIN':
                return Order::fromEntity($this->orderRepository->findById($id));
            case 'VENDOR':
                $order = Order::fromEntity($this->orderRepository->findByIdAndVendorId($id, AuthUtils::getVendorId()));
                $this->orderRepository->update($id, ['seenAt' => Carbon::now()->format('Y-m-d H:i:s')]);
                return $order;
                break;
        }
        return null;
    }


    public function save(SubmitOrderRequest $request) {
        $productIds = Arr::pluck($request['products'], 'productId');
        $productQuantities = Arr::pluck($request['products'], 'quantity');

        $quantityMappings = Array();
        foreach($request['products'] as $cartItem){
            $quantityMappings[$cartItem['productId']] = $cartItem['quantity'];
        }
        
        $cartTotal = $this->cartService->getTotalByIdsAndQuantities($productIds, $quantityMappings, $productQuantities);


        $order = new Order();
        $order->fill($request->toArray());
        $order->status = 'SUBMITTED';

        $order->shipping_price = $cartTotal->shippingPrice;
        $order->total = $cartTotal->total;
        $order->sub_total = $cartTotal->totalProductsPrice;
        $order->customer_id = AuthUtils::getUserId();
        $order->vendor_id = $request->vendorId;

        $order->save();
        $order_id = $order->id;

        $order_products = new Collection();
        foreach ($request['products'] as $row) {
            $prod = new OrderProduct();
            $prod->fill([
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'product_id' => $row['productId']
            ]);
            $order_products->push($prod);
        }
        $order->products()->saveMany($order_products);

        $vendorUser = $this->userRepository->findByVendorId($order->vendor_id);
        $vendor = $this->vendorRepository->findById($order->vendor_id);

        try {
            Mail::to($order->email)
                ->send(new OrderCreatedMail('customer', $order, $vendor));

            Mail::to($vendorUser->email)
                ->send(new OrderCreatedMail('vendor', $order, $vendor));
            logger("SUCCESS Email to ". $order->email);
            logger("SUCCESS Email to ". $vendorUser->email);
        } catch (Exception $ex) {
            logger("FAILED to send email to ". $order->email);
        }


        return ['id' => $order_id];
    }

    public function findByIdAndCustomerId($id) {
        return Order::fromEntity($this->orderRepository->findByIdAndCustomerId($id, AuthUtils::getUserId()));
    }

    public function findOrdersByCustomerId($id) {
        return $this->orderRepository->findAllByCustomerId($id);
    }

    
    public function getVendorOrderSummary($id) {
        $now = Carbon::now();
        $orders = Order::select(DB::raw('sum(total) as total'), DB::raw('count(*) as count'), DB::raw("DATE_FORMAT(createdAt,'%Y-%c-01') as month"))
            ->where('vendor_id', $id)
            ->groupBy('month')
            ->take(6)
            ->get();        
        
        $sales_this_month = Order::select(DB::raw('IFNULL(sum(total),0) as total'), DB::raw('count(*) as count'))
            ->where('vendor_id', $id)
            ->whereMonth('createdAt', '=', $now->month)
            ->first();
        
        $sales_today = Order::select(DB::raw('IFNULL(sum(total),0) as total'), DB::raw('count(*) as count'))
            ->where('vendor_id', $id)
            ->whereDate('createdAt', Carbon::today())->get()
            ->first();
        
        return array('aggregated'=> $orders, 'this_month'=> $sales_this_month, 'today'=> $sales_today, 'currency'=> new Currency());
    }
    
    public function sendTestEmail() {
        logger('Sending test email');
        $order = $this->orderRepository->findById(7);
        $vendor = $this->vendorRepository->findById(1);
        $user = $this->userRepository->findById(7);
        
        $emailContents = new OrderCreatedMail('customer', $order, $vendor);
        $emailContents = new OrderCreatedMail('vendor', $order, $vendor);
        // IN_PROGRESS, SHIPPED, COMPLETED
        //$emailContents = new OrderStatusChangeMail($order, $vendor , 'COMPLETED', 'Salam cu barba');
        //$emailContents = new UserCreatedMail($user);
        //$emailContents = new EmailChangeMail($user , 'salamescu@endava.com');
        //$emailContents = new PasswordResetMail($user , 'asdasdazcxcaa');
        //$emailContents = new PasswordResetConfirmationMail($user);

//        try {
//            Mail::to($order->email)
//                ->send($emailContents);
//        } catch (Exception $ex) {
//            return "We've got errors!";
//        }
        return $emailContents->render();
    }

}