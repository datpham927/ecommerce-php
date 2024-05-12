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
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('admin_name')->default("");
            $table->string('admin_password')->default("");
            $table->string('admin_address')->nullable();
            $table->string('admin_mobile')->nullable();
            $table->string('admin_image_url')->nullable();
            $table->string('admin_cmnd')->nullable();
            $table->string('admin_type')->default('admin'); //employee
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
        Schema::dropIfExists('admins');
    }
};
