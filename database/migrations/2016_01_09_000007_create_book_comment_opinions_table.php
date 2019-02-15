<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookCommentOpinionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_comment_opinions', function(Blueprint $table)
        {
            $table->integer('comment_id')->unsigned();
            $table->string('email');
            $table->boolean('agreed')->default(0);
            $table->boolean('reported')->default(0);
            $table->timestamps();

            $table->primary(['book_id', 'email']);
        });

        Schema::table('book_comment_opinions', function ($table) {
            $table->foreign('comment_id')->references('id')->on('book_comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('book_comment_opinions');
    }

}
