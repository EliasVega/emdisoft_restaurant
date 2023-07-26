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
        Schema::create('resolutions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('consecutive')->default(0);
            $table->string('prefix', 4)->nullable();
            $table->string('resolution', 20)->nullable()->unique();
            $table->date('resolution_date')->nullable();
            $table->string('technical_key', 64)->nullable();
            $table->bigInteger('start_number');
            $table->bigInteger('end_number');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['activa', 'inactiva'])->default('activa');
            $table->foreignId('company_id')->constrained();
            $table->foreignId('type_document_id')->constrained();

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
        Schema::dropIfExists('resolutions');
    }
};
