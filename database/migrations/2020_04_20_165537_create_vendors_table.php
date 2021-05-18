<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->string('businessName');
            $table->string('description')->nullable();
            $table->string('profilePicture')->nullable();
            $table->double('rating')->default(0);
            $table->integer('ratingCount')->default(0);
            $table->double('freeShippingOver')->nullable();
            $table->double('shippingCost')->nullable();
            $table->string('shippingRemarks')->nullable();

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
        Schema::dropIfExists('vendors');
    }
}
