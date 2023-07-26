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
        Schema::create('kardexes', function (Blueprint $table) {
            $table->id();

            $table->enum('operation', ['inventario', 'compra', 'editar compra', 'venta', 'editar venta', 'nc_compra','nd_compra','nc_venta', 'nd_venta']);
            $table->integer('number');
            $table->decimal('quantity',10,2);
            $table->decimal('stock',10,2);

            $table->foreignId('product_id')->constrained()->onUpdate('cascade');
            $table->foreignId('branch_id')->constrained()->onUpdate('cascade');

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
        Schema::dropIfExists('kardexes');
    }
};
