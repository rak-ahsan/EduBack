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
        Schema::create('uni_intake_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->constrained('universities')->cascadeOnDelete();
            $table->foreignId('uni_courses_id')->constrained('uni_courses')->cascadeOnDelete();
            $table->unsignedBigInteger('uni_intake_id');
            $table->foreign('uni_intake_id')
                  ->references('intake_id')
                  ->on('uni_intakes')
                  ->onDelete('cascade');

            $table->string('status')->default('active');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uni_intake_mappings');
    }
};
