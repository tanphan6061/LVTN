<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->default('http://localhost:8000/assets/images/avatar-placeholder.gif');
            $table->string('phone');
            $table->string('description', 500)->default('');
            $table->string('nameOfShop')->nullable();
            $table->string('slug')->nullable();
            $table->string('address')->nullable();
            $table->enum('role',['supplier','admin']); // default is supplier
            $table->boolean('is_activated')->default(1); // default is 1 (is active)
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
        Schema::dropIfExists('suppliers');
    }
}
