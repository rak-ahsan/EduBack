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
        Schema::create('student_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');

            $table->integer('overall_result')->nullable();
            $table->integer('reading')->nullable();
            $table->integer('writing')->nullable();
            $table->integer('speaking')->nullable();
            $table->integer('listening')->nullable();
            $table->date('examination_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_languages');
    }
};
