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
        Schema::create('ncpurchases', function (Blueprint $table) {
            $table->id();

            $table->string('purchase', 20);
            $table->decimal('total', 20, 2);
            $table->decimal('total_iva', 10, 2);
            $table->decimal('total_pay', 20, 2);
            $table->decimal('pay',10,2);
            $table->decimal('balance',10,2);
            $table->enum('status',['aprobada', 'cancelada'])->default('aprobada');

            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->foreignId('branch_id')->constrained()->onUpdate('cascade');
            $table->foreignId('purchase_id')->constrained()->onUpdate('cascade');
            $table->foreignId('supplier_id')->constrained()->onUpdate('cascade');
            $table->foreignId('nd_discrepancy_id')->constrained()->onUpdate('cascade');
            $table->foreignId('voucher_type_id')->constrained()->onUpdate('cascade');

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
        Schema::dropIfExists('ncpurchases');
    }
};
