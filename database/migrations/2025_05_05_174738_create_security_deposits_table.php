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
        Schema::create('security_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->string('transaction_type'); // Recive/return
            $table->string('deposit_amount')->nullable();           
            $table->string('deposit_document')->nullable();
            $table->string('ducoment_file_path')->nullable();
            $table->string('security_deposit_status')->default('Pending'); // Paid/Pending
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_deposits');
    }
};
