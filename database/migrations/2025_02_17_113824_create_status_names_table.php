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
        Schema::create('status_names', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_group_id')->constrained('status_groups')->onDelete('cascade');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_names');
    }
};
