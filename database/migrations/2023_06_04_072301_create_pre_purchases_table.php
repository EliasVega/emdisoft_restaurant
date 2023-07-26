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
        Schema::create('pre_purchases', function (Blueprint $table) {
            $table->id();

            $table->integer('items');
            $table->decimal('total', 20, 2);
            $table->decimal('total_iva', 11, 2);
            $table->decimal('total_pay', 20, 2);
            $table->decimal('balance', 20, 2);
            $table->enum('status',['active', 'generated', 'canceled'])->default('active');
            $table->string('note', 255)->nullable();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('branch_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained()->onUpdate('cascade');

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
        Schema::dropIfExists('pre_purchases');
    }
};
