<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();
        $seeders = array(CategorySeeder::class, UserSeeder::class, ProductSeeder::class,
            ShippingLocationsSeeder::class, OrderSeeder::class);

        foreach ($seeders as $seeder) {
            $this->call($seeder);
        }
        Model::reguard();
    }
}
