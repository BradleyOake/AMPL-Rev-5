<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 50);
            $table->text('description')->nullable();

            $table->decimal('electronic_price', 8, 2)->nullable();
            $table->decimal('audio_price', 8, 2)->nullable();
            $table->decimal('hard_price', 8, 2)->nullable();
            $table->decimal('soft_price', 8, 2)->nullable();

            $table->tinyInteger('in_hard')->default(0);
            $table->tinyInteger('in_soft')->default(0);

            $table->tinyInteger('status_id')->default(1);
            $table->string('isbn', 17)->unique();
            $table->date('published_at');

            $table->string('meta_keywords', 200)->nullable();
            $table->string('meta_description', 200)->nullable();

            $table->timestamps();

        });


        Schema::table('books', function ($table) {
            $table->foreign('status_id')->references('id')->on('statuses');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }

}
