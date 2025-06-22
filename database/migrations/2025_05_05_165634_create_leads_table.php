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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('resource')->nullable();

            $table->foreignId('marketer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('junior_consultant_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('abc_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('reference')->nullable();
            $table->string('academic_details')->nullable();
            $table->string('language_details')->nullable();
            $table->string('destination')->nullable();

            $table->foreignId('program_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('intake_id')->nullable()->constrained()->nullOnDelete();
            $table->date('intake_year')->nullable();

            $table->string('lead_finacial')->nullable();
            $table->string('lead_situation')->nullable();
            $table->foreignId('lead_status_id')->nullable()->constrained('status_names')->nullOnDelete();
            $table->date('appointment_date')->nullable();
            $table->string('last_call_status')->nullable();
            $table->date('last_call_date')->nullable();
            $table->integer('number_of_call')->nullable();
            $table->string('remarks')->nullable();

            //basic inforamtion end

            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('state_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();

            $table->string('address')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('alt_phone')->nullable();

            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('nationality')->nullable();
            $table->string('nid_number')->nullable();
            $table->string('nid_image')->nullable(); //images
            $table->string('user_image')->nullable();

            $table->string('passport_number')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('passport_image')->nullable();

            $table->enum('duplicate', ['Yes', 'No'])->default('No');
            $table->string('duplicate_number')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
