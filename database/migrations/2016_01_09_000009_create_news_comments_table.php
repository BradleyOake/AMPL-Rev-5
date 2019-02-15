<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsCommentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_comments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('news_id');
            $table->string('email');
            $table->string('name');
            $table->string('text');
            $table->timestamps();

        });

        Schema::table('news_comments', function ($table) {
            $table->foreign('id')->references('id')->on('news');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('news_comments');
    }

}
