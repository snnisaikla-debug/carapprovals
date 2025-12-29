<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('approvals', function (Blueprint $table) {
        $missing = [
            'sales_user_id'          => 'unsignedBigInteger',
            'sales_name'             => 'string',
            'customer_district'      => 'string',            
            'customer_province'      => 'string',
            'fn'                     => 'string',
            'car_model'              => 'string',
            'car_color'              => 'string',
            'car_options'            => 'text',
            'plus_head'              => 'decimal',
            'down_percent'           => 'decimal',
            'down_amount'            => 'decimal',
            'finance_amount'         => 'decimal',
            'installment_per_month'  => 'decimal',
            'installment_months'     => 'integer',
            'interest_rate'          => 'decimal',
            'fleet_amount'           => 'decimal',
            'sale_type_amount'       => 'decimal',
            'decoration_amount'      => 'decimal',
            'over_campaign_amount'   => 'decimal',
            'over_decoration_amount' => 'decimal',
            'free_items'             => 'text',
            'free_items_over'        => 'text',
            'extra_purchase_items'   => 'text',
            'campaigns_available'    => 'text',
            'campaigns_used'         => 'text',
            'over_reason'            => 'text',
            'is_commercial_30000'    => 'boolean',
            'status'                 => 'string',
            'version'                => 'integer',
            'group_id'               => 'integer',
            'created_by'             => 'string',
        ];

        foreach ($missing as $column => $type) {
            if (!Schema::hasColumn('approvals', $column)) {
                if ($type === 'decimal') $table->decimal($column, 15, 2)->default(0);
                elseif ($type === 'integer') $table->integer($column)->default(1);
                elseif ($type === 'text') $table->text($column)->nullable();
                elseif ($type === 'boolean') $table->boolean($column)->default(false);
                elseif ($type === 'unsignedBigInteger') $table->unsignedBigInteger($column)->nullable();
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
