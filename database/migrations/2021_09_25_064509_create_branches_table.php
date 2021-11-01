<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id('ID_Branch');
            $table->unsignedBigInteger('ID_User');
            $table->foreign('ID_User')->references('ID_User')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('branch_name');
            $table->string('city');
            $table->string('branch_address');
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
        Schema::dropIfExists('branches');
    }
}
