<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('order_id');
			$table->foreignId('transaction_id');
			$table->string('sernderName');
			$table->string('reciverName');
			$table->string('type')->default('new order');
			$table->string('Transaction_Amount');
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
