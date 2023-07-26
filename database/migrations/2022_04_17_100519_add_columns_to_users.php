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
        Schema::table('users', function (Blueprint $table) {

            $table->foreignId('company_id')->constrained()->after('id')->onUpdate('cascade');
            $table->foreignId('branch_id')->constrained()->after('company_id')->onUpdate('cascade');
            $table->foreignId('document_id')->constrained()->after('branch_id')->onUpdate('cascade');
            $table->foreignId('role_id')->constrained()->after('document_id')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
