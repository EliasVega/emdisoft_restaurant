<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_ndpurchase_payment_methods', function (Blueprint $table) {
            $table->id();

            $table->decimal('payment', 10,2);
            $table->string('transaction', 20);

            $table->foreignId('pay_ndpurchase_id')->constrained()->onUpdate('cascade');
            $table->foreignId('payment_method_id')->constrained()->onUpdate('cascade');
            $table->foreignId('bank_id')->constrained()->onUpdate('cascade');
            $table->foreignId('card_id')->constrained()->onUpdate('cascade');
            $table->foreignId('advance_id')->nullable()->constrained()->onUpdate('cascade');

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
        Schema::dropIfExists('pay_ndpurchase_payment_methods');
    }
};
