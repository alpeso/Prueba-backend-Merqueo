<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashRegisterTransactionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_register_transaction_log', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('cash_register_id');
            $table->foreign('cash_register_id')->references('id')->on('cash_registers');

            $table->unsignedBigInteger('transaction_log_id');
            $table->foreign('transaction_log_id')->references('id')->on('transaction_logs');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->integer('cash_register_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_register_transaction_log', function (Blueprint $table) {
            $table->dropForeign('cash_register_transaction_log_cash_register_id_foreign');
            $table->dropForeign('cash_register_transaction_log_transaction_log_id_foreign');
            $table->dropForeign('cash_register_transaction_log_user_id_foreign');
        });

        Schema::dropIfExists('cash_register_transaction_log');
    }
}
