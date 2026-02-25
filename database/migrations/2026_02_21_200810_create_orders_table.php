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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        
        // Menambahkan user_id di sini agar tidak perlu file migrasi tambahan
        $table->foreignId('user_id')->constrained('users'); 
        
        $table->foreignId('division_id')->constrained(); 
        $table->integer('plant_id')->nullable(); 
        
        $table->string('shift_time');
        $table->date('order_date');
        
        // Menambahkan status di sini
        $table->string('status')->default('pending');
        
        $table->text('remark')->nullable();
        
        $table->foreignId('created_by')->constrained('users'); 
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};