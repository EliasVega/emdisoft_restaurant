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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();

            $table->decimal('quantity', 10,2);
            $table->decimal('price', 11,2);
            $table->decimal('iva', 10,2);
            $table->decimal('subtotal', 11,2);
            $table->decimal('ivasubt', 11,2);
            $table->enum('status', ['enviado', 'nuevo'])->default('nuevo');

            $table->foreignId('order_id')->constrained()->onUpdate('cascade');
            $table->foreignId('product_id')->constrained()->onUpdate('cascade');

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
        Schema::dropIfExists('order_products');
    }
};
