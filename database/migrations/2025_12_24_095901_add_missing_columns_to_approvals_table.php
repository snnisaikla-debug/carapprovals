<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('approvals', function (Blueprint $table) {
        // 1. ตรวจสอบและสร้าง sales_name ก่อน
        if (!Schema::hasColumn('approvals', 'sales_name')) {
            $table->string('sales_name')->nullable();
        }

        // 2. ตรวจสอบและสร้าง sales_user_id (วางต่อจาก sales_name ได้แล้วเพราะสร้างไปข้างบนแล้ว)
        if (!Schema::hasColumn('approvals', 'sales_user_id')) {
            $table->unsignedBigInteger('sales_user_id')->nullable()->after('sales_name');
        }

        // 3. ตรวจสอบและสร้าง customer_district (ตัวต้นเหตุที่ทำให้บันทึกไม่ได้)
        if (!Schema::hasColumn('approvals', 'customer_district')) {
            $table->string('customer_district')->nullable()->after('customer_name');
        }

        // 4. เพิ่มคอลัมน์อื่นๆ ที่อาจจะยังขาดอยู่ (ถ้ามี)
        $others = ['customer_province', 'customer_phone', 'fn', 'status'];
        foreach ($others as $col) {
            if (!Schema::hasColumn('approvals', $col)) {
                $table->string($col)->nullable();
            }
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approvals', function (Blueprint $table) {
            //
        });
    }
};
