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
        Schema::table('estudiantes', function(Blueprint $table) {
            $table->foreignId('cdc_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('cdi_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('barrio_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function(Blueprint $table) {
            $table->dropConstrainedForeignId('cdc_id');
            $table->dropConstrainedForeignId('cdi_id');
            $table->dropConstrainedForeignId('barrio_id');
        });
    }
};
