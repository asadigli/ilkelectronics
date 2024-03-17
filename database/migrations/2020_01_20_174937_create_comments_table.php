<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('prod_id')->nullable()->references('id')->on('products');
            $table->integer('cat_id')->nullable()->references('id')->on('category');
            $table->integer('news_id')->nullable()->references('id')->on('news');
            $table->integer('page_id')->nullable()->references('id')->on('pages');
            $table->integer('user_id')->nullable()->references('id')->on('users');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->nullable();
            $table->float('rating')->default(0);
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
