<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = [
    'group_id',
    'version',
    'status',
    'car_model',
    'car_price',
    'customer_name',
    'remark',
    'created_by',

    'customer_district',
    'customer_province',
    'customer_phone',
    'car_color',
    'car_options',
    'plus_menager',
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
    ];
public function salesUser() {
    return $this->belongsTo(User::class, 'sales_user_id');
    }
}