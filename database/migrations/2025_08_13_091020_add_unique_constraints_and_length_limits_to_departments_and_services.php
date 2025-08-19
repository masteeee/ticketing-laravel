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
        // Update departments table
        Schema::table('departments', function (Blueprint $table) {
            // Add unique constraint to name column and set length limit
            $table->string('name', 100)->unique()->change();
        });

        // Update services table
        Schema::table('services', function (Blueprint $table) {
            // Set length limit for name column
            $table->string('name', 100)->change();
            
            // Add unique constraint for name within the same department
            $table->unique(['name', 'department_id'], 'services_name_department_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse departments table changes
        Schema::table('departments', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->string('name')->change();
        });

        // Reverse services table changes
        Schema::table('services', function (Blueprint $table) {
            $table->dropUnique('services_name_department_unique');
            $table->string('name')->change();
        });
    }
};
