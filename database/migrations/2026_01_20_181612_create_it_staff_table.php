<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('it_staff', function (Blueprint $table) {
            $table->string('staffNum')->primary();
            $table->string('fName');
            $table->string('lName');
            $table->string('ic', 12)->unique();
            $table->string('email')->unique();
            $table->string('pass');
            $table->string('countryCode', 3);
            $table->string('phoneOp', 2);
            $table->string('subNum', 8);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_staff');
    }
};
