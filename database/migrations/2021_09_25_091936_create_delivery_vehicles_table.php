<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_vehicles', function (Blueprint $table) {
            $table->id('ID_DeliveryVehicle');
            $table->unsignedBigInteger('ID_Admin');
            $table->foreign('ID_Admin')->references('ID_Admin')->on('admins')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('phone');
            $table->string('model');
            $table->string('plateNumber');
            $table->string('img');
            $table->integer('pricePerK');
            $table->integer('deliver');
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
        Schema::dropIfExists('delivery_vehicles');
    }
}
