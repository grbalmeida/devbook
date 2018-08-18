<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGroupPostsHasComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_posts_has_comments', function(Blueprint $table) {
            $table->integer('parent_id')->unsigned()->nullable();

            $table->foreign('parent_id')
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
        Schema::dropForeign('group_posts_has_comments_parent_id_foreign');
    }
}
