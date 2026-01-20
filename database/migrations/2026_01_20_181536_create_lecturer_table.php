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
        Schema::create('lecturer', function (Blueprint $table) {
            $table->string('staffNum')->primary();
            $table->string('fName');
            $table->string('lName');
            $table->string('ic', 12)->unique();
            $table->string('email')->unique();
            $table->string('pass');
            $table->string('countryCode', 3);
            $table->string('phoneOp', 2);
            $table->string('subNum', 8);
            $table->string('department');
            $table->string('officeBuilding');
            $table->string('officeFloor');
            $table->string('officeRoom');
            $table->string('qualification');
            
            $table->string('facCode');
            $table->foreign('facCode')->references('facCode')->on('faculty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer');
    }
};
