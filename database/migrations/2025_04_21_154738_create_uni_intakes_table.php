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
        Schema::create('uni_intakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->constrained('universities')->onDelete('cascade');
            $table->foreignId('intake_id')->constrained('intakes')->onDelete('cascade');
            $table->string('intake_application_date')->nullable();
            $table->string('intake_interview_date')->nullable();
            $table->string('intake_payment_date')->nullable();
            $table->string('intake_cas_coe_i_date')->nullable();
            $table->string('status')->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uni_intakes');
    }
};
