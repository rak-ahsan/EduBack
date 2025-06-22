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
        Schema::create('tuition_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->foreignId('university_id')->constrained()->onDelete('cascade');
            $table->foreignId('uni_campus_id')->constrained('uni_campuses')->onDelete('cascade');
            $table->foreignId('intake_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('uni_course_id')->constrained('uni_courses')->onDelete('cascade');
            $table->string('paid_through');
            $table->date('payment_date');
            $table->string('tuition_amount');
            $table->string('image')->nullable();
            $table->string('tuition_fees_status')->default('Pending'); // Paid/Pending
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuition_fees');
    }
};
