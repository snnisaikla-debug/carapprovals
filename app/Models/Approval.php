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
    'plus_head', 
    'fn',
    'down_percent', 
    'down_amount', 
    'finance_amount', 
    'installment_per_month',
    'installment_months', 
    'interest_rate', 
    'sc_signature', 
    'sale_com_signature',
    'is_commercial_30000', 
    'group_id', 'version', 
    'status', 'created_by', 
    'sales_name', 
    'sales_user_id'
];
}