<?php

use Illuminate\Database\Eloquent\Relations\MorphTo;
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
        Schema::create('cash_receipts', function (Blueprint $table) {
            $table->id();

            $table->decimal('pay', 10,2);
            $table->enum('type',['order', 'invoice', 'ndinvoice', 'advance', 'cash_in', 'ndpurchase']);
            $table->morphs('cash_receiptable');

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
        Schema::dropIfExists('cash_receipts');
    }
};
