<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id('ID_Unit');
            $table->unsignedBigInteger('ID_Category');
            $table->foreign('ID_Category')->references('ID_Category')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ID_Admin');
            $table->foreign('ID_Admin')->references('ID_Admin')->on('admins')->onDelete('cascade')->onUpdate('cascade');
            $table->string('privateKey');
            $table->boolean('status');
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
        Schema::dropIfExists('units');
    }
}
