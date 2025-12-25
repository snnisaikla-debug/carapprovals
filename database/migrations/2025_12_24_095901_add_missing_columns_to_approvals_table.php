<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('approvals', function (Blueprint $table) {
        // 1. รวมคอลัมน์ทั้งหมดที่ต้องการเพิ่มไว้ในที่เดียว
        $missingColumns = [
            'sales_user_id'          => 'unsignedBigInteger',
            'sales_name'             => 'string',
            'car_model'              => 'string',
            'car_color'              => 'string',
            'car_options'            => 'text',
            'plus_head'              => 'decimal',
            'fleet_amount'           => 'decimal',
            'sale_type_amount'       => 'decimal',
            'decoration_amount'      => 'decimal',
            'over_campaign_amount'   => 'decimal',
            'over_decoration_amount' => 'decimal',
            'chassis'                => 'string',
            'stock_number'           => 'string',
            'com_fn_option'          => 'string',
            'com_fn_amount'          => 'decimal',
            'insurance_deduct'       => 'decimal',
            'insurance_used'         => 'decimal',
            'kickback_amount'        => 'decimal',
            'free_items_over'        => 'text',
            'extra_purchase_items'   => 'text',
            'campaigns_available'    => 'text',
            'campaigns_used'         => 'text',
            'over_campaign_status'   => 'string',
            'over_decoration_status' => 'string',
            'over_reason'            => 'text',
            'sc_signature'           => 'string',
            'sale_com_signature'     => 'string',
            'is_commercial_30000'    => 'boolean',
        ];

        // 2. ใช้ Loop ตรวจสอบและสร้างคอลัมน์ (ป้องกัน Error Duplicate 100%)
        foreach ($missingColumns as $column => $type) {
            if (!Schema::hasColumn('approvals', $column)) {
                if ($type === 'decimal') {
                    $table->decimal($column, 15, 2)->default(0);
                } elseif ($type === 'text') {
                    $table->text($column)->nullable();
                } elseif ($type === 'boolean') {
                    $table->boolean($column)->default(false);
                } elseif ($type === 'unsignedBigInteger') {
                    $table->unsignedBigInteger($column)->nullable();
                } else {
                    $table->string($column)->nullable();
                }
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
