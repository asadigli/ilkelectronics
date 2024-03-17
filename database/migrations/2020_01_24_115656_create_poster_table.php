<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('author');
            $table->string('image')->unique();
            $table->integer('type')->default(0);// 0 means single poster, 1 means slide image
            $table->integer('prod_id')->nullable()->references('id')->on('products');
            $table->integer('news_id')->nullable()->references('id')->on('news');
            $table->integer('page_id')->nullable()->references('id')->on('pages');
            $table->text('title')->nullable();
            $table->text('details')->nullable();
            $table->string('button')->nullable();
            $table->string('button_href')->nullable();
            $table->string('button_type')->nullable();
            $table->string('order')->default(0);
            $table->string('status')->default(0); // 0 means not active, 1 means active
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('posters');
    }
}
