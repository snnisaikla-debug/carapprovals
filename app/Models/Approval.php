<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
    'customer_name', 'customer_district', 'customer_province', 'customer_phone',
    'car_model', 'car_color', 'car_options', 'car_price', 'plus_head', 'fn',
    'sales_name', 'sales_user_id', 'status', 'version', 'group_id', 'created_by',
    'down_percent', 'down_amount', 'finance_amount', 'installment_per_month', 
    'installment_months', 'interest_rate', 'fleet_amount', 'sale_type_amount',
    'decoration_amount', 'over_campaign_amount', 'over_decoration_amount',
    'free_items', 'free_items_over', 'extra_purchase_items', 'campaigns_available',
    'Request_date','Date_delivery','campaigns_used', 'over_reason', 'is_commercial_30000', 'sc_signature', 'sale_com_signature'
];
}