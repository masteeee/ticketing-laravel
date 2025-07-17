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
        Schema::table('departments', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->string('logo_url')->nullable();
        });
    }
    
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['description', 'logo_url']);
        });
    }
};
