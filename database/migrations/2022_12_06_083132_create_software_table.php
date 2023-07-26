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
        Schema::create('software', function (Blueprint $table) {
            $table->id();

            $table->string('identifier', 50)->nullable();
            $table->string('pin', 5)->nullable();
            $table->string('set', 64)->nullable();
            $table->string('payroll_identifier', 50)->nullable();
            $table->string('payroll_pin', 5)->nullable();
            $table->string('payroll_set', 64)->nullable();
            $table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('software');
    }
};
