<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id');
            $table->integer('creator')->references('id')->on('users');
            $table->string('slug')->unique();
            $table->string('shortname')->unique();
            $table->text('title');
            $table->text('body');
            $table->integer('footer')->default(0); // 0 means not in footer
            $table->integer('header')->default(0); // 0 means not in header
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
        Schema::dropIfExists('pages');
    }
}
