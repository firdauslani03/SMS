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
        Schema::create('registration', function (Blueprint $table) {
            $table->string('courseCode');
            $table->foreign('courseCode')->references('courseCode')->on('course');

            $table->string('matricNum');
            $table->foreign('matricNum')->references('matricNum')->on('student');

            $table->primary(['courseCode', 'matricNum']);

            $table->string('status');
            $table->date('registrationDate');
            $table->time('registrationTime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration');
    }
};
