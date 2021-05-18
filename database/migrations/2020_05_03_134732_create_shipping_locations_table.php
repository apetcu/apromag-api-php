<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->string('name');

            $table->timestamp('createdAt')->nullable();
            $table->timestamp('updatedAt')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_locations');
    }
}
