<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserPostsHasPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_posts_has_photos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->string('image', 150);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('post_id')
                ->references('id')
                ->on('user_has_posts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign('user_has_posts_post_id_foreign');
        Schema::dropIfExists('user_posts_has_photos');
    }
}
