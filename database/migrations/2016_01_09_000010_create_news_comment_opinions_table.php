<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsCommentOpinionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_comment_opinions', function(Blueprint $table)
        {
            $table->integer('comment_id')->unsigned();
            $table->string('email');
            $table->boolean('agreed')->default(0);
            $table->boolean('reported')->default(0);
            $table->timestamps();

             $table->primary(['comment_id', 'email']);
        });

        Schema::table('news_comment_opinions', function ($table) {
            $table->foreign('comment_id')->references('id')->on('news_comments');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('news_comment_opinions');
    }

}
