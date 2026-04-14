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
        Schema::table('leave_assignments', function (Blueprint $table) {
            // Index for user queries (most common)
            $table->index('user_id');
            
            // Index for leave type queries
            $table->index('leave_type_id');
            
            // Composite index for user + year queries (very common)
            $table->index(['user_id', 'year']);
            
            // Composite index for leave type + year queries
            $table->index(['leave_type_id', 'year']);
            
            // Index for year queries
            $table->index('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_assignments', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['leave_type_id']);
            $table->dropIndex(['user_id', 'year']);
            $table->dropIndex(['leave_type_id', 'year']);
            $table->dropIndex(['year']);
        });
    }
};
