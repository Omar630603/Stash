<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_schedules', function (Blueprint $table) {
            $table->id('ID_DeliverySchedule');
            $table->unsignedBigInteger('ID_Order');
            $table->foreign('ID_Order')->references('ID_Order')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ID_DeliveryVehicle');
            $table->foreign('ID_DeliveryVehicle')->references('ID_DeliveryVehicle')->on('delivery_vehicles')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('status');
            $table->dateTime('pickedUp');
            $table->dateTime('delivered');
            $table->string('location');
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
        Schema::dropIfExists('delivery_schedules');
    }
}
