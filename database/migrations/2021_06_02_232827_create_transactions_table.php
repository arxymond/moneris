<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     * Transactions table holds initial data like customer_id, payment_method_id, amount and state
     * as well as some of the Moneris Response values
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('payment_method_id');
            $table->string('state');
            $table->decimal('amount', 8, 2); // not using unsigned for refund cases
            $table->string('CardType')->nullable()->default(null);
            $table->string('TransAmount')->nullable()->default(null);
            $table->string('TxnNumber')->nullable()->default(null);
            $table->string('ReceiptId')->nullable()->default(null);
            $table->string('TransType')->nullable()->default(null);
            $table->string('ReferenceNum')->nullable()->default(null);
            $table->string('ResponseCode')->nullable()->default(null);
            $table->string('ISO')->nullable()->default(null);
            $table->string('Message')->nullable()->default(null);
            $table->string('IsVisaDebit')->nullable()->default(null);
            $table->string('AuthCode')->nullable()->default(null);
            $table->string('Complete')->nullable()->default(null);
            $table->string('TransDate')->nullable()->default(null);
            $table->string('TransTime')->nullable()->default(null);
            $table->string('Ticket')->nullable()->default(null);
            $table->string('TimedOut')->nullable()->default(null);
            $table->string('StatusCode')->nullable()->default(null);
            $table->string('StatusMessage')->nullable()->default(null);
            $table->string('HostId')->nullable()->default(null);
            $table->string('IssuerId')->nullable()->default(null);
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
