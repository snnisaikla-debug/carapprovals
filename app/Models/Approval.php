<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        // customer
        'customer_name', 
        'customer_district', 
        'customer_province', 
        'customer_phone',

        // car
        'car_model', 
        'car_color', 
        'car_options', 
        'car_price',

        // finance
        'fn', 
        'down_percent', 
        'down_amount', 
        'finance_amount',
        'installment_per_month', 
        'installment_months', 
        'interest_rate',

        // ของแถมและสถานะ
        'free_items',
        'free_items_over', 
        'extra_purchase_items',
        'is_commercial_30000', 
        'group_id',
        'version', 
        'status', 

        // ส่วนของ Sales
        'sales_name',
        'sales_user_id',
        'sale_type_amount',
        'plus_head',
        'chassis',
        'stock_number',
        'com_fn_option', 
        'com_fn_amount',
        'sc_signature',
        'sale_com_signature', 
        
        // campaign
        'fleet_amount', 
        'insurance_deduct', 
        'insurance_used',
        'kickback_amount', 
        'campaigns_available', 
        'campaigns_used', 
        'decoration_amount',
        'over_campaign_amount', 
        'over_campaign_status', 
        'over_decoration_amount',
        'over_decoration_status', 
        'over_reason', 
        'created_by', 
    ];
}