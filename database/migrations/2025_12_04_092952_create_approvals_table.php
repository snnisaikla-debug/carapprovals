<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            // ข้อมูลลูกค้า
            $table->string('customer_name')->nullable();
            $table->string('customer_district')->nullable();
            $table->string('customer_province')->nullable();
            $table->string('customer_phone')->nullable();

            // ข้อมูลรถ (ที่ Error ฟ้องบ่อย)
            $table->string('car_model')->nullable();
            $table->string('car_color')->nullable();
            $table->text('car_options')->nullable();
            $table->decimal('car_price', 15, 2)->default(0);
            $table->decimal('plus_head', 15, 2)->default(0); // ตัวที่ Error ล่าสุดฟ้อง

            // การเงินและส่วนลด
            $table->string('fn')->nullable();
            $table->integer('down_percent')->default(0);
            $table->decimal('down_amount', 15, 2)->default(0);
            $table->decimal('finance_amount', 15, 2)->default(0);
            $table->decimal('installment_per_month', 15, 2)->default(0);
            $table->integer('installment_months')->default(0);
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->decimal('sale_type_amount', 15, 2)->nullable();
            $table->decimal('fleet_amount', 15, 2)->nullable();
            $table->decimal('insurance_deduct', 15, 2)->default(0);
            $table->decimal('insurance_used', 15, 2)->default(0);
            $table->decimal('kickback_amount', 15, 2)->default(0);
            $table->string('com_fn_option')->nullable();
            $table->decimal('com_fn_amount', 15, 2)->default(0);

            // รายการของแถม (ดึงจากฟอร์ม)
            $table->text('free_items')->nullable();
            $table->text('free_items_over')->nullable();
            $table->text('extra_purchase_items')->nullable();
            $table->text('campaigns_available')->nullable();
            $table->text('campaigns_used')->nullable();
            $table->string('over_campaign_status')->nullable();
            $table->string('over_decoration_status')->nullable();

            // ระบบสถานะและ Versioning
            $table->boolean('is_commercial_30000')->default(false);
            $table->integer('group_id')->default(0);
            $table->integer('version')->default(1);
            $table->string('status')->default('WAIT_ADMIN');
            $table->string('created_by')->nullable();
            $table->string('sales_name')->nullable(); // ตัวนี้ที่ Error ฟ้องในรูปที่ 3

            $table->timestamps();
        });
    }

    public function up_down(): void { Schema::dropIfExists('approvals'); }
};