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
        $table->foreignId('sales_user_id')->nullable()->constrained('users');
        $table->string('sales_name')->nullable();
        
        // ข้อมูลลูกค้า (อิงตามฟอร์ม)
        $table->string('customer_name');
        $table->string('customer_district')->nullable();
        $table->string('customer_province')->nullable();
        $table->string('customer_phone')->nullable();

        // ข้อมูลรถ
        $table->string('car_model');
        $table->string('car_color')->nullable();
        $table->text('car_options')->nullable();
        $table->decimal('car_price', 15, 2);

        // การเงิน (Finance)
        $table->decimal('plus_head', 15, 2)->nullable();
        $table->string('fn')->nullable();
        $table->decimal('down_percent', 5, 2)->nullable();
        $table->decimal('down_amount', 15, 2)->nullable();
        $table->decimal('finance_amount', 15, 2)->nullable();
        $table->decimal('installment_per_month', 15, 2)->nullable();
        $table->integer('installment_months')->nullable();
        $table->decimal('interest_rate', 5, 2)->nullable();

        // ของแถมและส่วนลด
        $table->decimal('sale_type_amount', 15, 2)->nullable();
        $table->decimal('fleet_amount', 15, 2)->nullable();
        $table->decimal('kickback_amount', 15, 2)->nullable();
        $table->text('campaigns_available')->nullable();
        $table->text('campaigns_used')->nullable();
        $table->text('free_items')->nullable();
        $table->text('free_items_over')->nullable();
        $table->text('extra_purchase_items')->nullable();
        $table->decimal('decoration_amount', 15, 2)->nullable();
        $table->decimal('over_campaign_amount', 15, 2)->nullable();
        $table->decimal('over_decoration_amount', 15, 2)->nullable();

        // หมายเหตุและลายเซ็น
        $table->text('over_reason')->nullable();
        $table->text('remark')->nullable();
        $table->longText('sc_signature_data')->nullable();
        $table->longText('sale_com_signature_data')->nullable();
        $table->boolean('is_commercial_30000')->default(false);

        // ระบบเวอร์ชัน (Version Control)
        $table->integer('group_id')->default(0);
        $table->integer('version')->default(1);
        $table->string('status')->default('Draft');
        $table->string('created_by')->nullable();
        
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