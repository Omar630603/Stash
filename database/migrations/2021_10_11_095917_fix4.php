<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Fix4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_schedules', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('delivery_schedules', function (Blueprint $table) {
            $table->boolean('status')->after('ID_DeliveryVehicle')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
