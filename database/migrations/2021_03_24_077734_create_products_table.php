<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->integer('price');
            $table->bigInteger('sub_category_id')->unsigned();
            $table->bigInteger('brand_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->integer('amount');
            $table->string('description');
            $table->string('detail');
            $table->enum('status',['available','out_of_stock']);
            $table->integer('discount');
            $table->boolean('is_deleted');

            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
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
        Schema::dropIfExists('products');
    }
}