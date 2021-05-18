<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->string('shippingAddress');
            $table->string('fullName');
            $table->string('email');
            $table->string('phone');
            $table->string('status');
            $table->text('remarks');
            $table->double('shipping_price');
            $table->double('total');
            $table->double('sub_total');

            $table->unsignedInteger('customer_id')->index();
            $table->unsignedInteger('vendor_id')->index();
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('vendor_id')->references('id')->on('vendors');

            $table->timestamp('seenAt')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
