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
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("n_user_id")->nullable(true);
            $table->string("n_title"); 
            $table->string("n_subtitle"); 
            $table->string("n_link"); 
            $table->string("n_image"); 
            $table->string("n_type")->default('user');// system 
            $table->boolean("n_is_watched")->default(false); 
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
        Schema::dropIfExists('notifications');
    }
};
