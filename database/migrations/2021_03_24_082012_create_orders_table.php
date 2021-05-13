<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            //$table->bigInteger('discount_code_id')->unsigned();
            $table->string('phone');
            $table->string('address');
            //$table->dateTime('datetime');
            $table->string('payment_type');
            $table->integer('total_price');
            $table->enum('status', ['cancel', 'delivered', 'shipping']);
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('discount_code_id')->references('id')->on('discount_codes');
            $table->timestamps();
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
