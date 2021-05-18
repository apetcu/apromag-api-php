<?php

use Carbon\Carbon;
use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends CsvSeeder {

    public function __construct() {
        $this->table = 'categories';
        $this->csv_delimiter = '|';
        $this->filename = base_path() . '/database/seeds/csv/categories.csv';
        $this->should_trim = true;
    }

    public function run() {
        DB::disableQueryLog();
        DB::table($this->table)->truncate();

        parent::run();
    }
}
