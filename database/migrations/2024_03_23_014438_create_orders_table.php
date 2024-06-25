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
            $table->uuid('id')->primary();
            $table->integer('od_user_id')->nullable;
            $table->string('od_user_name')->nullable;
            $table->string('od_user_phone')->default(0); 
            $table->boolean('od_is_pay')->default(false);
            $table->string('od_paymentMethod')->default('CASH');
            $table->boolean('od_is_confirm')->default(false);
            $table->boolean('od_is_confirm_delivery')->default(false);
            $table->boolean('od_is_delivering')->default(false);
            $table->integer('od_is_canceled')->default(false);
            $table->boolean('od_is_success')->default(false);
            $table->string('od_shipping_address')->default(false);
            $table->string('od_shipping_address_detail')->default(false);
            $table->double('od_shipping_price')->default(0); 
            $table->double('od_price_total')->nullable;  
            $table->date('od_date_shipping')->nullable;  
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
