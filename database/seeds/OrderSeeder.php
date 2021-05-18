<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder {
    private $table = 'orders';
    private $table_products = 'order_products';

    public function run() {
        DB::table($this->table)->truncate();
        DB::table($this->table_products)->truncate();

        $id = DB::table($this->table)->insertGetId([
            'shippingAddress' => 'shipping address',
            'fullName' => 'Adrian Petcu',
            'email' => 'adipetcu@yahoo.com',
            'phone' => '0785864545',
            'status' => 'SUBMITTED',
            'remarks' => 'Comanda noua',
            'shipping_price' => 10.50,
            'sub_total' => 100,
            'total' => 110.50,
            'vendor_id' => 1,
            'customer_id' => 1,
            'createdAt' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table($this->table_products)->insert([[
            'name' => 'Rosii Roma',
            'quantity' => 3,
            'price' => 100,
            'product_id' => 1,
            'order_id' => $id,
            'createdAt' => Carbon::now()->format('Y-m-d H:i:s')
        ],
            [
                'name' => 'Rosii Bune',
                'quantity' => 3,
                'price' => 100,
                'product_id' => 2,
                'order_id' => $id,
                'createdAt' => Carbon::now()->format('Y-m-d H:i:s')
            ]]);
    }
}
