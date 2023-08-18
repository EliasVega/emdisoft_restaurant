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
        Schema::create('home_orders', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('address', 100);
            $table->string('phone', 255);
            $table->string('domiciliary', 50)->nullable();
            $table->time('time_receipt');
            $table->time('time_sent')->nullable();

            $table->foreignId('order_id')->constrained()->onUpdate('cascade');

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
        Schema::dropIfExists('home_orders');
    }
};
