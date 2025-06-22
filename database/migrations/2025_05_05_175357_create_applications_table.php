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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lead_id')->constrained()->onDelete('cascade');

            $table->foreignId('admission_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('compliance_id')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->foreignId('state_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('university_id')->constrained()->onDelete('cascade');
            $table->foreignId('uni_campus_id')->constrained('uni_campuses')->onDelete('cascade');
            $table->foreignId('uni_program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('uni_course_id')->constrained('uni_courses')->onDelete('cascade');
            $table->foreignId('uni_intake_id')->constrained('intakes')->onDelete('cascade');
            $table->foreignId('lead_status_id')->constrained('status_names')->onDelete('cascade');

            $table->string('application_fees_status')->default('Pending'); // Paid/Pending
            $table->string('application_fees_amount')->nullable();

            //consultant lead sheet
            $table->string('applied_via')->nullable();
            $table->date('submitted_portal_date')->nullable();
            $table->date('submitted_university_date')->nullable();
            $table->string('application_confirmation')->nullable();
            $table->date('offer_letter_date')->nullable();
            $table->string('offer_letter_desc')->nullable();
            $table->string('scholarship')->nullable();
            $table->string('scholarship_amount')->nullable();
            $table->string('student_id')->nullable();
            $table->string('portal_student_id')->nullable();

            //complince lead sheet
            $table->string('medical_test')->nullable();
            $table->date('medical_test_date')->nullable();
            $table->string('mock_interview')->nullable();
            $table->string('mock_interview_qty')->nullable();
            $table->date('cas_interview_date')->nullable();
            $table->string('interview_invitation')->nullable();
            $table->string('interview_link')->nullable();
            $table->string('cas_interview_result')->nullable();
            $table->date('cas_coe_loa_request')->nullable();
            $table->string('cas_coe_loa_receive')->nullable();
            $table->date('visa_application_date')->nullable();
            $table->date('visa_result')->nullable();
            $table->date('visa_interview')->nullable();
            $table->string('air_ticket_booked')->nullable();
            $table->date('flying_date')->nullable();
            $table->string('enrollment')->nullable();
            $table->date('class_start_date')->nullable();
            $table->date('class_end_date')->nullable();
            $table->string('notification')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
