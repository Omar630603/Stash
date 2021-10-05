<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Fix1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->double('address_latitude')->nullable();
            $table->double('address_longitude')->nullable();
        });
        Schema::table('units', function (Blueprint $table) {
            $table->string('IdName')->after('ID_Admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('address_latitude');
            $table->dropColumn('address_longitude');
        });
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('IdName');
        });
    }
}
