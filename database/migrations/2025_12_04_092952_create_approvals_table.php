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
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            
            // ข้อมูลพื้นฐานเบื้องต้น
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            
            // ข้อมูลรถเบื้องต้น
            $table->string('car_model')->nullable();
            $table->decimal('car_price', 15, 2)->default(0);

            // ระบบสถานะ (หัวใจหลักของ Workflow)
            $table->string('status')->default('Pending_Admin'); 
            $table->integer('version')->default(1);
            $table->integer('group_id')->default(0);

            $table->timestamps(); // สร้าง created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};