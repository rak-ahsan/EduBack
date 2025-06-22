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
        Schema::create('student_academics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');

            $table->string('group')->nullable();
            $table->string('course')->nullable();
            $table->string('cgpa')->nullable();
            $table->string('scale')->nullable();
            $table->string('duration')->nullable();
            $table->date('passing_year')->nullable();
            $table->string('institute')->nullable();
            $table->date('course_start_date')->nullable();
            $table->date('course_end_date')->nullable();
            $table->string('certificate_image')->nullable();
            $table->string('transcript_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_academics');
    }
};
