<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pay_expense_payment_methods', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pay_expense_id')->constrained()->onUpdate('cascade');
            $table->foreignId('payment_method_id')->constrained()->onUpdate('cascade');
            $table->foreignId('bank_id')->constrained()->onUpdate('cascade');
            $table->foreignId('card_id')->constrained()->onUpdate('cascade');
            $table->foreignId('payment_id')->nullable()->constrained()->onUpdate('cascade');

            $table->decimal('payment', 20,2);
            $table->string('transaction', 20);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_expense_payment_methods');
    }
};
