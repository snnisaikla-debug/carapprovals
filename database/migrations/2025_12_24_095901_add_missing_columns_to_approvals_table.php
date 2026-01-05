<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('approvals', function (Blueprint $table) {
        // เพิ่มคอลัมน์ที่ Error แจ้งว่าไม่พบ
        if (!Schema::hasColumn('approvals', 'customer_district')) {
            $table->string('customer_district')->nullable()->after('customer_name');
        }
        if (!Schema::hasColumn('approvals', 'car_color')) {
            $table->string('car_color')->nullable()->after('car_model');
        }
        // เพิ่มคอลัมน์อื่นๆ ที่อาจจะขาด (ตามใน Controller)
        if (!Schema::hasColumn('approvals', 'customer_province')) {
            $table->string('customer_province')->nullable();
        }
        if (!Schema::hasColumn('approvals', 'customer_phone')) {
            $table->string('customer_phone')->nullable();
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
