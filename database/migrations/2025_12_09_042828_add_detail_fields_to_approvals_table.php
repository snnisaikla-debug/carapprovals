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
        // 1. ข้อมูลลูกค้า
        $table->string('customer_district')->nullable();   // 1.2 อำเภอ
        $table->string('customer_province')->nullable();   // 1.3 จังหวัด
        $table->string('customer_phone')->nullable();      // 1.4 เบอร์โทร

        // 2. ข้อมูลรถ
        $table->string('car_color')->nullable();           // 2.2 สี
        $table->string('car_options')->nullable();         // 2.3 ออฟชั่น

        // 3. บวกหัว
        $table->decimal('plus_head', 10, 2)->nullable();

        // 4. F/N
        $table->string('fn')->nullable();

        // 5. ดาวน์ (% , บาท)
        $table->decimal('down_percent', 5, 2)->nullable();
        $table->decimal('down_amount', 10, 2)->nullable();

        // 6. ยอดจัด
        $table->decimal('finance_amount', 10, 2)->nullable();

        // 7–8 งวดละ / จำนวนงวด
        $table->decimal('installment_per_month', 10, 2)->nullable();
        $table->integer('installment_months')->nullable();

        // 9. ดอกเบี้ย (%)
        $table->decimal('interest_rate', 5, 2)->nullable();

        // 10. รหัสแคมเปญ
        $table->string('campaign_code')->nullable();

        // 11. ประเภทการขาย
        $table->string('sale_type')->nullable();          // GE, Retention, เกษตรกร, Welcome
        $table->decimal('sale_type_amount', 10, 2)->nullable(); // 11.1 จำนวน (บาท)

        // 12. Fleet (บาท)
        $table->decimal('fleet_amount', 10, 2)->nullable();

        // 13. หักประกัน / ใช้จริง
        $table->decimal('insurance_deduct', 10, 2)->nullable();
        $table->decimal('insurance_used', 10, 2)->nullable();

        // 14. kickback (บาท)
        $table->decimal('kickback_amount', 10, 2)->nullable();

        // 15. Com F/N (ตัวเลือก + ระบุบาท)
        $table->string('com_fn_option')->nullable();      // dropdown: 4,8,10,12,14,16
        $table->decimal('com_fn_amount', 10, 2)->nullable();

        // 16–18 รายการของแถม / ของแถมเกิน / ซื้อเพิ่ม
        $table->text('free_items')->nullable();           // ของแถม
        $table->text('free_items_over')->nullable();      // ของแถมเกิน
        $table->text('extra_purchase_items')->nullable(); // ซื้อเพิ่ม

        // 19–20 แคมเปญ
        $table->text('campaigns_available')->nullable();  // แคมเปญที่มี
        $table->text('campaigns_used')->nullable();       // แคมเปญที่ใช้

        // 21. commercial 30,000
        $table->boolean('is_commercial_30000')->default(false);
        // 22. รายการแต่ง (มูลค่า)
        $table->decimal('decoration_amount', 10, 2)->nullable();

        // 23. เกินแคมเปญ
        $table->decimal('over_campaign_amount', 10, 2)->nullable();
        $table->string('over_campaign_status')->nullable();   // ไม่เกิน / เกิน

        // 24. เกินของตกแต่ง
        $table->decimal('over_decoration_amount', 10, 2)->nullable();
        $table->string('over_decoration_status')->nullable(); // ไม่เกิน / เกิน

        // 25. สาเหตุขอเกิน
        $table->text('over_reason')->nullable();

        // 26–27 ลายเซ็น (ตอนนี้เก็บเป็น text ชื่อ/โน้ตไว้ก่อน)
        $table->string('sc_signature')->nullable();
        $table->string('sale_com_signature')->nullable();

        // ชื่อ sales เจ้าของดีล (ใช้แสดง / sort)
        $table->string('sales_name')->nullable();
    });
}

public function down(): void
{
    Schema::table('approvals', function (Blueprint $table) {
        $table->dropColumn([
            'customer_district',
            'customer_province',
            'customer_phone',
            'car_color',
            'car_options',
            'plus_head',
            'fn',
            'down_percent',
            'down_amount',
            'finance_amount',
            'installment_per_month',
            'installment_months',
            'interest_rate',
            'campaign_code',
            'sale_type',
            'sale_type_amount',
            'fleet_amount',
            'insurance_deduct',
            'insurance_used',
            'kickback_amount',
            'com_fn_option',
            'com_fn_amount',
            'free_items',
            'free_items_over',
            'extra_purchase_items',
            'campaigns_available',
            'campaigns_used',
            'is_commercial_30000',
            'decoration_amount',
            'over_campaign_amount',
            'over_campaign_status',
            'over_decoration_amount',
            'over_decoration_status',
            'over_reason',
            'sc_signature',
            'sale_com_signature',
            'sales_name',
        ]);
    });
}
};
