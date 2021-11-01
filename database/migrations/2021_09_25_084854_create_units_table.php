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
            $table->unsignedBigInteger('ID_Branch');
            $table->foreign('ID_Branch')->references('ID_Branch')->on('branches')->onDelete('cascade')->onUpdate('cascade');
            $table->string('unit_name');
            $table->string('privateKey');
            $table->boolean('unit_status')->default(0);
            $table->integer('capacity')->default(0);
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
