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
        // ข้อมูลลูกค้า
        $table->string('customer_name')->nullable();
        $table->string('customer_district')->nullable();
        $table->string('customer_province')->nullable();
        $table->string('customer_phone')->nullable();

        // ข้อมูลรถ
        $table->string('car_model')->nullable();
        $table->string('car_color')->nullable();
        $table->text('car_options')->nullable();
        $table->decimal('car_price', 15, 2)->default(0);

        // การเงินและส่วนลด
        $table->string('fn')->nullable();
        $table->integer('down_percent')->default(0);
        $table->decimal('down_amount', 15, 2)->default(0);
        $table->decimal('finance_amount', 15, 2)->default(0);
        $table->decimal('installment_per_month', 15, 2)->default(0);
        $table->integer('installment_months')->default(0);
        $table->decimal('interest_rate', 5, 2)->default(0);

        // ของแถมและสถานะ
        $table->text('free_items')->nullable();
        $table->string('status')->default('WAIT_ADMIN');
        $table->integer('version')->default(1);
        $table->integer('group_id')->nullable(); // สำหรับทำ Versioning
        
        $table->timestamps();
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
