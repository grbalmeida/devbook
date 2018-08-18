<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FriendshipRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendship_request', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('requested_user_id')->unsigned();
            $table->integer('request_user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('requested_user_id')
                ->references('id')
                ->on('users');

            $table->foreign('request_user_id')
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
        Schema::dropForeign('user_requested_user_id_foreign');
        Schema::dropForeign('user_request_user_id_foreign');
        Schema::dropIfExists('friendship_request');
    }
}
