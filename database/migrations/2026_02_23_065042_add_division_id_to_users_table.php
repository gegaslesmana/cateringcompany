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
        Schema::table('users', function (Blueprint $table) {
    // Menghubungkan user ke tabel divisions
    $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('cascade');
    $table->string('role')->default('Operator'); // Operator (PIC), HRD, atau Security
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
