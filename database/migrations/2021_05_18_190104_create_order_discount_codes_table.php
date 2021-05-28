<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_discount_codes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('discount_code_id')->unsigned();
            $table->text('description');
            $table->integer('discount');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('discount_code_id')->references('id')->on('discount_codes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_discount_codes');
    }
}
