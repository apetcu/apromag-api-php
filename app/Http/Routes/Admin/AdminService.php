<?php

namespace App\Http\Routes\Admin;

use App\Http\Routes\Order\Models\Order;
use App\Http\Routes\Product\Models\Product;
use App\Http\Routes\User\Models\User;
use App\Http\Routes\User\UserRepository;
use App\Http\Routes\User\UserService;
use App\Http\Routes\Vendor\Models\Vendor;
use App\Http\Routes\Vendor\VendorRepository;
use App\Http\Routes\Vendor\VendorService;
use App\Utils\AuthUtils;
use Carbon\CarbonImmutable;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;
use Tymon\JWTAuth\JWTAuth;

class AdminService {
    private $userRepository;
    private $vendorRepository;
    private $analyticsService;
    private $vendorService;
    private $jwtAuth;

    public function __construct(UserRepository $userRepository, Analytics $analyticsService, VendorRepository $vendorRepository, VendorService $vendorService, UserService $userService, JWTAuth $JWTAuth) {
        $this->userRepository = $userRepository;
        $this->vendorRepository = $vendorRepository;
        $this->vendorService = $vendorService;
        $this->userService = $userService;
        $this->analyticsService = $analyticsService;
        $this->jwtAuth = $JWTAuth;
    }

    public function getStatistics() {
        $counts = $this->getCounts();
        $history = $this->getHistory();
        return array(
            'counts' => $counts,
            'history' => $history
        );
    }

    public function getAnalytics() {
        return $this->analyticsService->fetchVisitorsAndPageViews(Period::days(7));
    }

    public function getCounts(): array {
        $vendor_count = Vendor::count();
        $counts = array(
            'orders' => Order::count(),
            'products' => Product::count(),
            'customers' => User::count() - $vendor_count,
            'vendors' => $vendor_count,
        );
        return $counts;
    }

    public function getHistory(): array {
        $to = CarbonImmutable::now()->addDay()->format('Y-m-d');
        $from = CarbonImmutable::now()->subDays(30)->format('Y-m-d');

        return array(
            'orders' => $this->getOrderHistory($from, $to),
            'customerRegistrations' => $this->getCustomerRegistrationHistory($from, $to),
            'vendorRegistrations' => $this->getVendorRegistrationHistory($from, $to),
            'products' => $this->getProductsHistory($from, $to)
        );
    }

    public function getCustomerRegistrationHistory($from, $to) {
        $users = User::select(DB::raw('count(*) as count'), DB::raw("DATE(createdAt) as day"))
            ->where('role', 'CUSTOMER')
            ->whereDate('createdAt', '>=', date($from) . ' 00:00:00')
            ->whereDate('createdAt', '<=', date($to) . ' 00:00:00')
            ->groupBy('day')
            ->get();
        return $this->padEmptyValues($from, $to, $users->toArray(), array('count' => 0));
    }
    
    public function getVendorRegistrationHistory($from, $to) {
        $users = User::select(DB::raw('count(*) as count'), DB::raw("DATE(createdAt) as day"))
            ->where('role', 'VENDOR')
            ->whereDate('createdAt', '>=', date($from) . ' 00:00:00')
            ->whereDate('createdAt', '<=', date($to) . ' 00:00:00')
            ->groupBy('day')
            ->get();
        return $this->padEmptyValues($from, $to, $users->toArray(), array('count' => 0));
    }    
    
    public function getProductsHistory($from, $to) {
        $products = Product::select(DB::raw('count(*) as count'), DB::raw("DATE(createdAt) as day"))
            ->whereDate('createdAt', '>=', date($from) . ' 00:00:00')
            ->whereDate('createdAt', '<=', date($to) . ' 00:00:00')
            ->groupBy('day')
            ->get();
        return $this->padEmptyValues($from, $to, $products->toArray(), array('count' => 0));
    }

    public function getOrderHistory($from, $to) {
        $orders = DB::table('orders')
            ->select(DB::raw('DATE(createdAt) as day'), DB::raw('sum(total) as total'), DB::raw('count(*) as count'))
            ->whereDate('createdAt', '>=', date($from) . ' 00:00:00')
            ->whereDate('createdAt', '<=', date($to) . ' 00:00:00')
            ->groupBy('day')
            ->get();
        return $this->padEmptyValues($from, $to, $orders->toArray(), array('total' => 0, 'count' => 0));
    }

    private function padEmptyValues($from, $to, $data, $placeholder) {
        $returnValues = [];
        $period = new DatePeriod(new DateTime($from), new DateInterval('P1D'), new DateTime($to));
        foreach ($period as $date) {
            $found = array_search($date->format("Y-m-d"), array_column($data, 'day'));
            if (!$found) {
                array_push($returnValues, array_merge(array('day'=>$date->format("Y-m-d")), $placeholder));
            } else {
                array_push($returnValues, $data[$found]);
            }
        }
        return $returnValues;
    }

}