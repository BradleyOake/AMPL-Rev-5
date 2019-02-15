<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookCommentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_comments', function(Blueprint $table)
        {
             $table->increments('id');
            $table->integer('book_id')->unsigned();
            $table->string('email');
            $table->string('name');
            $table->string('text');
            $table->tinyInteger('rating');
            $table->boolean('approved');
            $table->timestamps();

            $table->primary(['book_id', 'email']);
        });

       Schema::table('book_comments', function ($table) {
            $table->foreign('book_id')->references('id')->on('books');
             $table->foreign('email')->references('email')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books_comments');
    }

}
