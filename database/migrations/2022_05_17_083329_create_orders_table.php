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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->decimal('total',20,2);
            $table->decimal('total_iva',11,2);
            $table->decimal('total_pay',20,2);
            $table->enum('status', ['pendiente', 'facturado', 'anulada'])->default('pendiente');

            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->foreignId('restaurant_table_id')->constrained()->onUpdate('cascade');

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
        Schema::dropIfExists('orders');
    }
};
