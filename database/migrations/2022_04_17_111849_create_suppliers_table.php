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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('number', 20)->unique();
            $table->string('dv', 1)->nullable();
            $table->string('address', 100);
            $table->string('phone', 20);
            $table->string('email', 45);
            $table->string('contact', 50);
            $table->string('phone_contact', 20);

            $table->foreignId('department_id')->constrained()->onUpdate('cascade');
            $table->foreignId('municipality_id')->constrained()->onUpdate('cascade');
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
        Schema::dropIfExists('suppliers');
    }
};
