<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('ID_Transaction');
            $table->unsignedBigInteger('ID_Order');
            $table->foreign('ID_Order')->references('ID_Order')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ID_Bank')->nullable();
            $table->foreign('ID_Bank')->references('ID_Bank')->on('banks')->onDelete('cascade')->onUpdate('cascade');
            $table->string('transactions_description');
            $table->integer('transactions_totalPrice');
            $table->integer('transactions_status')->default(0);
            $table->string('proof');
            $table->boolean('transaction_madeBy')->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
