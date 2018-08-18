<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Groups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->unsigned();
            $table->string('name', 150);
            $table->boolean('type');
            $table->text('description')->nullable();
            $table->string('cover_photo', 150)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('admin_id')
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
        Schema::dropForeign('users_admin_id_foreign');
        Schema::dropIfExists('groups');
    }
}
