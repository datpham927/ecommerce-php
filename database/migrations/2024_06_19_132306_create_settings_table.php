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
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('setting_company_name')->nullable();
            $table->string('setting_slogan')->nullable();
            $table->string('setting_logo')->nullable();
            // --- thông tin liên hệ
            $table->string('setting_phone')->nullable();
            $table->string('setting_email')->nullable();
            $table->string('setting_address')->nullable();
            $table->text('setting_map')->nullable();
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
        Schema::dropIfExists('settings');
    }
};
