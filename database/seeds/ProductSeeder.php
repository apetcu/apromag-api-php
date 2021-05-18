<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder {
    private $table = 'products';

    public function run() {
        DB::table($this->table)->truncate();
        DB::table($this->table)->insert([
            'name' => 'Rosii',
            'category_id' => 1,
            'vendor_id' => 1,
            'description' => 'Rosiile alea bune din Bucuresti',
            'stock' => 1,
            'unit' => 'kg',
            'price' => 20.50,
            'createdAt' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table($this->table)->insert([
            'name' => 'Castraveti',
            'category_id' => 1,
            'vendor_id' => 1,
            'description' => 'Rosiile alea bune din Bucuresti',
            'stock' => 1,
            'unit' => 'kg',
            'price' => 10,
            'createdAt' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table($this->table)->insert([
            'name' => 'Conopida',
            'category_id' => 1,
            'vendor_id' => 1,
            'description' => 'Rosiile alea bune din Bucuresti',
            'stock' => 1,
            'unit' => 'kg',
            'price' => 15,
            'createdAt' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
