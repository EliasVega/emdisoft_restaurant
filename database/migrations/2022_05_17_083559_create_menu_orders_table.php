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
        Schema::create('menu_orders', function (Blueprint $table) {
            $table->id();

            $table->decimal('quantity', 10,2);
            $table->decimal('price', 11,2);
            $table->decimal('inc', 10,2);
            $table->decimal('subtotal', 11,2);
            $table->decimal('incsubt', 11,2);
            $table->boolean('edition')->default(true);
            $table->enum('status', ['registrado', 'nuevo', 'anulado'])->default('nuevo');

            $table->foreignId('order_id')->constrained()->onUpdate('cascade');
            $table->foreignId('menu_id')->constrained()->onUpdate('cascade');
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
        Schema::dropIfExists('menu_orders');
    }
};
