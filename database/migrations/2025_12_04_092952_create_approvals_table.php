<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
            {
            Schema::create('approvals', function (Blueprint $table) {
        $table->id();
        
        // 1. ข้อมูลลูกค้าและพื้นที่
        $table->string('customer_name')->nullable();
        $table->string('customer_district')->nullable();
        $table->string('customer_province')->nullable();
        $table->string('customer_phone')->nullable();

        // 2. ข้อมูลรถยนต์
        $table->string('car_model')->nullable();
        $table->string('car_color')->nullable();
        $table->text('car_options')->nullable(); // สำหรับเก็บรายละเอียดออปชั่น
        $table->decimal('car_price', 15, 2)->default(0);

        // 3. เงื่อนไขทางการเงิน (Finance)
        $table->string('fn')->nullable(); // สถาบันการเงิน
        $table->integer('down_percent')->default(0);
        $table->decimal('down_amount', 15, 2)->default(0);
        $table->decimal('finance_amount', 15, 2)->default(0);
        $table->decimal('installment_per_month', 15, 2)->default(0);
        $table->integer('installment_months')->default(0);
        $table->decimal('interest_rate', 5, 2)->default(0);

        // 4. ส่วนลดและแคมเปญ
        $table->decimal('sale_type_amount', 15, 2)->default(0); // ประเภทการขาย (GE/Fleet)
        $table->decimal('fleet_amount', 15, 2)->default(0);
        $table->decimal('insurance_deduct', 15, 2)->default(0);
        $table->decimal('insurance_used', 15, 2)->default(0);
        $table->decimal('kickback_amount', 15, 2)->default(0);
        $table->string('com_fn_option')->nullable(); // ค่าคอม F/N
        $table->decimal('com_fn_amount', 15, 2)->default(0);

        // 5. รายการของแถมและส่วนเพิ่ม
        $table->text('free_items')->nullable(); // รายการของแถมปกติ
        $table->text('free_items_over')->nullable(); // รายการของแถมเกิน
        $table->text('extra_purchase_items')->nullable(); // รายการซื้อเพิ่ม
        $table->text('campaigns_available')->nullable(); // แคมเปญที่มี
        $table->text('campaigns_used')->nullable(); // แคมเปญที่ใช้

        // 6. ตรวจสอบเงื่อนไขเกินงบ (Over Budget)
        $table->decimal('decoration_amount', 15, 2)->default(0);
        $table->decimal('over_campaign_amount', 15, 2)->default(0);
        $table->integer('over_campaign_status')->default(0); // 0=ไม่เกิน, 1=เกิน
        $table->decimal('over_decoration_amount', 15, 2)->default(0);
        $table->integer('over_decoration_status')->default(0);
        $table->text('over_reason')->nullable(); // สาเหตุที่ขอเกิน

        // 7. ข้อมูลสถานะและระบบ
        $table->string('sc_signature')->nullable(); // ชื่อที่ปรึกษาการขาย
        $table->string('sale_com_signature')->nullable();
        $table->integer('is_commercial_30000')->default(0);
        $table->integer('group_id')->default(1);
        $table->integer('version')->default(1);
        $table->string('status')->default('WAIT_ADMIN'); // สถานะ Workflow
        $table->string('created_by')->nullable();
        $table->string('sales_name')->nullable();

        $table->timestamps(); // สร้าง created_at และ updated_at ให้อัตโนมัติ
        
         Schema::table('approvals', function (Blueprint $table) {
            if (!Schema::hasColumn('approvals', 'customer_name')) {
                $table->string('customer_name')->nullable();
            }
            if (!Schema::hasColumn('approvals', 'customer_district')) {
                $table->string('customer_district')->nullable();
            }
            if (!Schema::hasColumn('approvals', 'customer_province')) {
                $table->string('customer_province')->nullable();
            }
            if (!Schema::hasColumn('approvals', 'customer_phone')) {
                $table->string('customer_phone')->nullable();
            }
        });
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('approvals');
        Schema::table('approvals', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'customer_district',
                'customer_province',
                'customer_phone',
            ]);
        });
    }
};
