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
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->string('uni_name');
            $table->string('application_fees');
            $table->string('ranking');
            $table->string('initial_deposit');
            $table->string('usp');
            $table->text('scholarship')->nullable();
            $table->text('uni_academic_req');
            $table->string('uni_link')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
