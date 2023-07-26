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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('number', 20)->unique();
            $table->string('dv', 1)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 45)->nullable();
            $table->decimal('credit_limit', 10, 2);
            $table->decimal('used', 10, 2);
            $table->decimal('available', 10, 2);

            $table->foreignId('department_id')->constrained()->onUpdate('cascade')->nullable();
            $table->foreignId('municipality_id')->constrained()->onUpdate('cascade')->nullable();
            $table->foreignId('document_id')->constrained()->onUpdate('cascade');
            $table->foreignId('liability_id')->constrained()->onUpdate('cascade');
            $table->foreignId('organization_id')->constrained()->onUpdate('cascade');
            $table->foreignId('regime_id')->constrained()->onUpdate('cascade');

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
        Schema::dropIfExists('customers');
    }
};
