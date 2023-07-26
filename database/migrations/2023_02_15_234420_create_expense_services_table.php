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
        Schema::create('expense_services', function (Blueprint $table) {
            $table->id();

            $table->decimal('quantity', 10, 2);
            $table->decimal('price', 11, 2);
            $table->decimal('iva', 10, 2);
            $table->decimal('subtotal', 11, 2);
            $table->decimal('ivasubt', 11, 2);
            $table->integer('item');

            $table->foreignId('expense_id')->constrained()->onUpdate('restrict');
            $table->foreignId('service_id')->constrained()->onUpdate('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_services');
    }
};
