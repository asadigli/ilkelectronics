<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('prod_id')->references('id')->on('products');
            $table->integer('user_id')->nullable()->references('id')->on('users');
            $table->string('name');
            $table->string('surname');
            $table->string('father_name')->nullable();
            $table->string('email');
            $table->string('id_seria')->nullable();
            $table->string('id_number')->nullable();
            $table->string('id_pin')->nullable();
            $table->string('contact_number');
            $table->integer('gender')->nullable();
            $table->date('birthdate');
            $table->integer('quantity')->default(1);
            $table->integer('loan_type')->references('id')->on('loans');
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->integer('status')->default(0); // 0 means not seen yet, 1 means "done"
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
        Schema::dropIfExists('orders');
    }
}
