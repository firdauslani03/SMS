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
        Schema::create('course', function (Blueprint $table) {
            $table->string('courseCode')->primary();
            $table->string('courseName');
            $table->string('courseDesc');
            $table->integer('courseSem');
            $table->integer('courseCreds');
            $table->string('courseLocBuilding');
            $table->string('courseLocRoom');
            $table->string('coursePreReq')->nullable();
            $table->string('courseDate');
            $table->string('courseTime');

            $table->string('progCode');
            $table->foreign('progCode')->references('progCode')->on('programme')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course');
    }
};
