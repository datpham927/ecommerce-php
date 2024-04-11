<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('od_userId')->nullable;
    $table->boolean('od_is_pay')->default(false);
    $table->string('od_paymentMethod')->default('CASH');
    $table->boolean('od_is_confirm')->default(false);
    $table->boolean('od_is_confirm_delivery')->default(false);
    $table->boolean('od_is_delivering')->default(false);
    $table->integer('od_is_canceled')->default(false);
    $table->boolean('od_is_success')->default(false);
    $table->string('od_shippingAddress')->default(false);
    $table->double('od_shippingPrice')->default(0); 
    $table->date('od_dateShipping')->nullable; 

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
};
