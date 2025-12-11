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
            $table->unsignedBigInteger('group_id');    // กลุ่มเอกสารชุดเดียวกัน
            $table->unsignedInteger('version');        // เวอร์ชันที่เท่าไร
            $table->enum('status', [
                'WAIT_ADMIN',      // รอ Admin
                'WAIT_HEAD',       // ผ่าน Admin รอหัวหน้า
                'APPROVED',        // ผ่านทุกขั้นตอน
                'REJECTED_ADMIN',  // Admin ไม่อนุมัติ
                'REJECTED_HEAD',   // หัวหน้าไม่อนุมัติ
            ])->default('WAIT_ADMIN');

            $table->string('car_model');
            $table->decimal('car_price', 10, 2);
            $table->string('customer_name')->nullable();
            $table->text('remark')->nullable();

            $table->string('created_by')->nullable();  // ใครเป็นคนสร้างเวอร์ชันนี้
            $table->timestamps();
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
