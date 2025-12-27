<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
            'Request_date',
            'Date_delivery',
            'sales_user_id',         
            'sales_name',            
            'created_by',
            'status',
            'version',
            'group_id',           
            'customer_district',     
            'customer_province',     
            'car_model',              
            'car_color',             
            'car_options',            
            'plus_head',             
            'fn',                   
            'down_percent',        
            'down_amount',            
            'finance_amount',         
            'installment_per_month',  
            'installment_months',    
            'interest_rate',          
            'fleet_amount',           
            'sale_type_amount',     
            'decoration_amount',     
            'over_campaign_amount',   
            'over_decoration_amount', 
            'chassis',                
            'stock_number',          
            'com_fn_option',         
            'com_fn_amount',         
            'insurance_used',         
            'kickback_amount',       
            'free_items',            
            'free_items_over',       
            'extra_purchase_items',  
            'campaigns_available',    
            'campaigns_used',         
            'over_campaign_status',   
            'over_decoration_status',
            'over_reason',            
            'sc_signature',           
            'sale_com_signature',   
            'is_commercial_30000',
    ];
}