<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('ID_Order');
            $table->unsignedBigInteger('ID_User');
            $table->foreign('ID_User')->references('ID_User')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ID_Unit');
            $table->foreign('ID_Unit')->references('ID_Unit')->on('units')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('status');
            $table->dateTime('startsFrom');
            $table->dateTime('endsAt');
            $table->boolean('delivery');
            $table->integer('totalPrice');
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
