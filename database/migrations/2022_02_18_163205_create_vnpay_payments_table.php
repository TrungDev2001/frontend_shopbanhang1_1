<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVnpayPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vnpay_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('oder_id')->nullable();
            $table->integer('vnp_Amount')->nullable();
            $table->string('vnp_BankCode', 50)->nullable();
            $table->string('vnp_BankTranNo', 50)->nullable();
            $table->string('vnp_CardType', 50)->nullable();
            $table->string('vnp_OrderInfo')->nullable();
            $table->string('vnp_PayDate', 50)->nullable();
            $table->integer('vnp_ResponseCode')->nullable();
            $table->string('vnp_TmnCode', 50)->nullable();
            $table->integer('vnp_TransactionNo')->nullable();
            $table->integer('vnp_TransactionStatus')->nullable();
            $table->string('vnp_TxnRef', 50)->nullable();
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
        Schema::dropIfExists('vnpay_payments');
    }
}
