<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 
        'customer_district', 
        'customer_province', 
        'customer_phone',
        'car_model', 
        'car_color', 
        'car_options', 
        'car_price',
        'fn', 'down_percent', 
        'down_amount', 
        'finance_amount',
        'installment_per_month', 
        'installment_months', 
        'interest_rate',
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
        'decoration_amount',
        'over_campaign_amount', 
        'over_campaign_status', 
        'over_decoration_amount',
        'over_decoration_status', 
        'over_reason', 
        'sc_signature',
        'sale_com_signature', 
        'is_commercial_30000', 
        'group_id',
        'version', 
        'status', 
        'created_by', 
        'sales_name'
    ];
}