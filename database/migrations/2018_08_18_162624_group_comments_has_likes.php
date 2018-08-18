<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupCommentsHasLikes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_comments_has_likes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('comment_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('comment');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('comment_id')
                ->references('id')
                ->on('group_posts_has_comments');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign('group_posts_has_comments_comment_id_foreign');
        Schema::dropForeign('users_user_id_foreign');
        Schema::dropIfExists('group_comments_has_likes');
    }
}
