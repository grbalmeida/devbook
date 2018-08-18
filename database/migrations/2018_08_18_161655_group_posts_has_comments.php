<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupPostsHasComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_posts_has_comments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('comment');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('post_id')
                ->references('id')
                ->on('group_has_posts');

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
        Schema::dropForeign('group_has_posts_post_id_foreign');
        Schema::dropForeign('users_user_id_foreign');
        Schema::dropIfExists('group_posts_has_comments');
    }
}
