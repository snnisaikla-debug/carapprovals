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
    Schema::table('approvals', function (Blueprint $table) {
        // เช็คก่อนว่าถ้ายังไม่มีคอลัมน์นี้ ถึงจะเพิ่ม
        if (!Schema::hasColumn('approvals', 'sales_user_id')) {
            $table->bigInteger('sales_user_id')->unsigned()->nullable()->after('id');
        }
        
        // สำหรับคอลัมน์อื่นๆ ที่คุณต้องการเพิ่ม (เช่นที่เคย Error ก่อนหน้านี้) ให้ใส่เช็คแบบนี้ด้วยครับ
        if (!Schema::hasColumn('approvals', 'customer_district')) {
            $table->string('customer_district')->nullable();
        }
        if (!Schema::hasColumn('approvals', 'car_color')) {
            $table->string('car_color')->nullable();
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
