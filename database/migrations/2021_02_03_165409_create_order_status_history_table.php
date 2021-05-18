<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('previous');
            $table->string('next');
            $table->unsignedInteger('order_id')->nullable()->index();

            $table->timestamp('createdAt')->nullable();
            $table->timestamp('updatedAt')->nullable();
        });


        Schema::table('order_status_history', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status_history');
    }
}
