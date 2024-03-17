<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('prod_id')->unique();
          $table->text('productname');
          $table->string('slug')->unique();
          $table->integer('category')->references('id')->on('category');
          $table->integer('views')->default(0);
          $table->string('token')->unique();
          $table->integer('quantity')->default(0);
          $table->float('price');
          $table->float('old_price')->nullable();
          $table->text('description_title')->nullable();
          $table->string('brand')->default('N/A');
          $table->text('description')->nullable();
          $table->integer('condition')->default(0); //	condition 0 means new, 1 means used
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
        Schema::dropIfExists('products');
    }
}
