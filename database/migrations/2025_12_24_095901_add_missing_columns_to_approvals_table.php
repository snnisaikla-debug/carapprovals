<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('approvals', function (Blueprint $table) {
        $columns = [
            'Date_delivery' => 'date',
            'Request_date' => 'date',
            'customer_name' => 'string',
            'customer_district' => 'string',
            'customer_province' => 'string',
            'customer_phone' => 'string',
            'car_model' => 'string',
            'car_color' => 'string',
            'car_options' => 'text',
            'car_price' => 'decimal',
            'plus_head' => 'decimal',
            'fn' => 'string',
            'down_percent' => 'decimal',
            'down_amount' => 'decimal',
            'finance_amount' => 'decimal',
            'installment_per_month' => 'decimal',
            'installment_months' => 'integer',
            'interest_rate' => 'decimal',
            'sale_type_amount' => 'decimal',
            'fleet_amount' => 'decimal',
            'free_items' => 'text',
            'free_items_over' => 'text',
            'extra_purchase_items' => 'text',
            'campaigns_available' => 'text',
            'campaigns_used' => 'text',
            'decoration_amount' => 'decimal',
            'over_campaign_amount' => 'decimal',
            'over_decoration_amount' => 'decimal',
            'over_reason' => 'text',
            'sc_signature' => 'text',
            'sale_com_signature' => 'text',
            'is_commercial_30000' => 'boolean',
            'sales_name' => 'string',
            'status' => 'string',
            'version' => 'integer',
            'group_id' => 'integer',
            'created_by' => 'string',
        ];

        foreach ($columns as $column => $type) {
            if (!Schema::hasColumn('approvals', $column)) {
                if ($type === 'decimal') $table->decimal($column, 15, 2)->nullable();
                elseif ($type === 'integer') $table->integer($column)->default(0);
                elseif ($type === 'boolean') $table->boolean($column)->default(false);
                elseif ($type === 'text') $table->text($column)->nullable();
                else $table->string($column)->nullable();
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
