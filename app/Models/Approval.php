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

    // 2. ข้อมูลรถ (Car Info)
    'car_model',
    'car_color',
    'car_options',
    'car_price',

    // 3. ข้อมูลการเงิน (Finance & Installment)
    'plus_head',
    'fn',
    'down_percent',
    'down_amount',
    'finance_amount',
    'installment_per_month',
    'installment_months',
    'interest_rate',

    // 4. แคมเปญและส่วนลด (Campaign & Discounts)
    'sale_type_amount',
    'fleet_amount',
    'kickback_amount',
    'campaigns_available',
    'campaigns_used',

    // 5. รายการของแถมและอุปกรณ์ตกแต่ง (Free Items & Decoration)
    'free_items',
    'free_items_over',
    'extra_purchase_items',
    'decoration_amount',
    'over_campaign_amount',
    'over_decoration_amount',

    // 6. ข้อมูลอื่นๆ และสาเหตุ (Others)
    'over_reason',
    'remark',

    // 7. ลายเซ็น (Signature Data - รับค่าเป็น Base64)
    'sc_signature_data',     
    'sale_com_signature_data'
];
}