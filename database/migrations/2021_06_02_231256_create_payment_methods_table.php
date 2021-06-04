<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('card_number', 20);
            $table->string('card_holder');
            $table->date('exp_date'); // storing full date but we will use just Year and Month
            $table->boolean('is_default');
            $table->softDeletes(); // Using softDelete for in case of PaymentMethod was deleted by customer, the Transactions still be usable
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
        Schema::dropIfExists('payment_methods');
    }
}
