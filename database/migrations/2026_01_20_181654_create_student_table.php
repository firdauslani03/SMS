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
        Schema::create('student', function (Blueprint $table) {
            $table->string('matricNum')->primary();
            $table->string('fName');
            $table->string('lName');
            $table->string('ic', 12)->unique();
            $table->string('email')->unique();
            $table->string('pass');
            $table->integer('year');
            $table->integer('semester');
            $table->string('countryCode', 3);
            $table->string('phoneOp', 2);
            $table->string('subNum', 8);
            $table->decimal('cgpa', 3, 2);

            $table->string('facCode');
            $table->foreign('facCode')->references('facCode')->on('faculty');

            $table->string('progCode');
            $table->foreign('progCode')->references('progCode')->on('programme');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
