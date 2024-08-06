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
        Schema::create('user_interested_categories', function (Blueprint $table) {
            $table->increments("id");
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('views')->default(0);
            $table->timestamps(); 
             // Thêm chỉ mục cho user_id và product_id
             $table->index(['user_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_interested_categories');
    }
};
