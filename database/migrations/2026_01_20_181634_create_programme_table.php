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
        Schema::create('programme', function (Blueprint $table) {
            $table->string('progCode')->primary();
            $table->string('progName');
            $table->integer('progYears');

            $table->string('facCode');
            $table->foreign('facCode')->references('facCode')->on('faculty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programme');
    }
};
