<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Settings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('profile_picture', 150)->nullable()->default('default.jpg');
            $table->string('cover_photo', 150)->nullable();
            $table->text('biography')->nullable();
            $table->string('hometown', 150)->nullable();
            $table->string('actual_city', 150)->nullable();
            $table->string('occupation', 150)->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign('user_user_id_foreign');
        Schema::dropIfExists('settings'); 
    }
}
