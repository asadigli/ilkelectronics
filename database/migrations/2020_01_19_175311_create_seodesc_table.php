<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeodescTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seodesc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('prod_id')->nullable()->references('id')->on('products');
            $table->integer('cat_id')->nullable()->references('id')->on('category');
            $table->integer('news_id')->nullable()->references('id')->on('news');
            $table->integer('page_id')->nullable()->references('id')->on('pages');
            $table->text('body');
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
        Schema::dropIfExists('seodesc');
    }
}
