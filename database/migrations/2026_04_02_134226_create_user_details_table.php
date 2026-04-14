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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            
            // User relationship
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Basic Information
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('mobile_number', 20)->nullable();
            $table->string('email')->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            
            // Parent Information
            $table->string('parent_name')->nullable();
            $table->enum('relation', ['father', 'mother', 'brother', 'sister', 'uncle', 'aunt'])->nullable();
            $table->string('parent_mobile_number', 20)->nullable();
            
            // Permanent Address
            $table->text('permanent_address1')->nullable();
            $table->text('permanent_address2')->nullable();
            $table->foreignId('permanent_city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('permanent_state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->string('permanent_pincode', 10)->nullable();
            
            // Current Address
            $table->text('current_address1')->nullable();
            $table->text('current_address2')->nullable();
            $table->foreignId('current_city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('current_state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->string('current_pincode', 10)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
