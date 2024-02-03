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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name')->nullable;
            $table->string('product_slug');
            $table->string('product_thumb')->nullable;
            $table->string('product_description');
            $table->float('product_ratings')->default('4.5');
            $table->integer('product_admin_id');
            $table->integer('product_category_id');
            $table->integer('product_brand_id');
            $table->boolean('product_isPublished')->default(true);
            $table->boolean('product_isDraft')->default(false);
            $table->integer('product_stock')->default(0);
            $table->integer('product_discount')->default(0);
            $table->integer('product_quantity')->default(0);
            $table->float('product_price')->nullable;
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
};
