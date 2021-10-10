<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Fix3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_schedules', function (Blueprint $table) {
            $table->dropColumn('location');
        });
        Schema::table('delivery_schedules', function (Blueprint $table) {
            $table->string('pickedUpFrom')->after('delivered');
            $table->string('deliveredTo')->after('pickedUpFrom');
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
