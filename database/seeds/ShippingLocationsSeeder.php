<?php

use Carbon\Carbon;
use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingLocationsSeeder extends CsvSeeder {

    public function __construct() {
        $this->table = 'shipping_locations';
        $this->csv_delimiter = '|';
        $this->filename = base_path() . '/database/seeds/csv/locations.csv';
        $this->should_trim = true;
    }

    public function run() {
        DB::disableQueryLog();
        DB::table($this->table)->truncate();

        parent::run();
    }
}
