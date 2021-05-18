<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder {
    private $table = 'users';
    private $table_vendors = 'vendors';

    public function run() {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table($this->table)->truncate();
        DB::table($this->table_vendors)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $id = DB::table($this->table)->insertGetId([
            'firstName' => 'Customer',
            'lastName' => 'Cutomer 1',
            'address' => 'Address',
            'phone' => 'phone',
            'email' => 'customer@customer.com',
            'password' => bcrypt('password'),
            'role' => 'CUSTOMER',
            'createdAt' => Carbon::now()->format('Y-m-d H:i:s')
        ]);


        $vendor_user_id = DB::table($this->table_vendors)->insertGetId([
            'businessName' => 'VENDOR 1',
            'address' => 'Cilieni, Olt',
            'profilePicture' => 'Test salam',
            'shippingCost' => 10.00,
            'freeShippingOver' => 100.00,
            'createdAt' => Carbon::now()->format('Y-m-d H:i:s')
        ]);


        DB::table($this->table)->insertGetId([
            'firstName' => 'Vendor',
            'lastName' => 'Vendor 1',
            'address' => 'Address',
            'phone' => 'phone',
            'email' => 'vendor@vendor.com',
            'vendor_id' => $vendor_user_id,
            'password' => bcrypt('password'),
            'role' => 'VENDOR',
            'createdAt' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
