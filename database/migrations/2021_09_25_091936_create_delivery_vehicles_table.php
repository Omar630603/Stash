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
            $table->unsignedBigInteger('ID_Branch');
            $table->foreign('ID_Branch')->references('ID_Branch')->on('branches')->onDelete('cascade')->onUpdate('cascade');
            $table->string('vehicle_name');
            $table->string('vehicle_phone');
            $table->string('model');
            $table->string('plateNumber')->unique();
            $table->string('vehicle_img')->default('DeliveryVehicle_images/deliveryVehicleDefault.png');
            $table->integer('pricePerK');
            $table->integer('vehicle_deliveries')->default(0);
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
