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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name')->default("");
            $table->string('user_email')->unique()->default("");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_password')->default("");
            $table->string('user_address')->nullable();
            $table->string('user_mobile')->nullable();
            $table->string('user_image_url')->nullable();
            $table->boolean('user_is_block')->default(0);
            $table->rememberToken(); 
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
        Schema::dropIfExists('users');
    }
};
