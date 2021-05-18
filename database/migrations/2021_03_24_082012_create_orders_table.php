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
            //$table->bigInteger('shipping_address_id')->unsigned();
            $table->string('payment_type');
            $table->integer('subtotal');
            $table->integer('discount_amount')->default(0);
            $table->integer('grand_total');
            $table->enum('status', ['cancel', 'delivered', 'shipping']);
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('shipping_address_id')->references('id')->on('shipping_addresses');
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
