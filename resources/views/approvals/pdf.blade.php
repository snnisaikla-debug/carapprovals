<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ใบอนุมัติการขายรถ Group {{ $current->group_id }}</title>

    <style>
        /* ประกาศฟอนต์ไทยให้ dompdf รู้จัก */
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew', DejaVu Sans, sans-serif;
            font-size: 14pt;
        }

        h2, h3, h4, h5, h6, strong, b {
            font-family: 'THSarabunNew', DejaVu Sans, sans-serif;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-family: 'THSarabunNew', DejaVu Sans, sans-serif;
            font-size: 12pt;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h2>ใบอนุมัติการขายรถยนต์</h2>
    <p>Group: {{ $current->group_id }} | Version: {{ $current->version }} | Status: {{ $current->status }}</p>
    <p>Sales: {{ $current->sales_name }}</p>

    <div class="section-title">1. ข้อมูลลูกค้า</div>
    <table>
        <tr><td>ชื่อลูกค้า</td><td>{{ $current->customer_name }}</td></tr>
        <tr><td>อำเภอ</td><td>{{ $current->customer_district }}</td></tr>
        <tr><td>จังหวัด</td><td>{{ $current->customer_province }}</td></tr>
        <tr><td>เบอร์โทร</td><td>{{ $current->customer_phone }}</td></tr>
    </table>

    <div class="section-title">2. ข้อมูลรถ</div>
    <table>
        <tr><td>รุ่นรถ</td><td>{{ $current->car_model }}</td></tr>
        <tr><td>สี</td><td>{{ $current->car_color }}</td></tr>
        <tr><td>ออฟชั่น</td><td>{{ $current->car_options }}</td></tr>
        <tr><td>ราคา</td><td>{{ number_format($current->car_price,2) }}</td></tr>
    </table>

    <div class="section-title">ข้อมูลไฟแนนซ์</div>
    <table>
        <tr><td>บวกหัว</td><td>{{ $current->plus_head }}</td></tr>
        <tr><td>F/N</td><td>{{ $current->fn }}</td></tr>
        <tr><td>ดาวน์ (%)</td><td>{{ $current->down_percent }}</td></tr>
        <tr><td>ดาวน์ (บาท)</td><td>{{ $current->down_amount }}</td></tr>
        <tr><td>ยอดจัด</td><td>{{ $current->finance_amount }}</td></tr>
        <tr><td>งวดละ</td><td>{{ $current->installment_per_month }}</td></tr>
        <tr><td>จำนวนงวด</td><td>{{ $current->installment_months }}</td></tr>
        <tr><td>ดอกเบี้ย (%)</td><td>{{ $current->interest_rate }}</td></tr>
    </table>

    <div class="section-title">แคมเปญ / ส่วนลด</div>
    <table>
        <tr><td>รหัสแคมเปญ</td><td>{{ $current->campaign_code }}</td></tr>
        <tr><td>ประเภทการขาย</td><td>{{ $current->sale_type }}</td></tr>
        <tr><td>จำนวน (บาท)</td><td>{{ $current->sale_type_amount }}</td></tr>
        <tr><td>Fleet (บาท)</td><td>{{ $current->fleet_amount }}</td></tr>
        <tr><td>หักประกัน</td><td>{{ $current->insurance_deduct }}</td></tr>
        <tr><td>ใช้จริง</td><td>{{ $current->insurance_used }}</td></tr>
        <tr><td>Kickback</td><td>{{ $current->kickback_amount }}</td></tr>
        <tr><td>Com F/N</td><td>{{ $current->com_fn_option }} ({{ $current->com_fn_amount }})</td></tr>
    </table>

    <div class="section-title">ของแถม / ซื้อเพิ่ม / แคมเปญ</div>
    <table>
        <tr><td>ของแถม</td><td>{{ $current->free_items }}</td></tr>
        <tr><td>ของแถมเกิน</td><td>{{ $current->free_items_over }}</td></tr>
        <tr><td>ซื้อเพิ่ม</td><td>{{ $current->extra_purchase_items }}</td></tr>
        <tr><td>แคมเปญที่มี</td><td>{{ $current->campaigns_available }}</td></tr>
        <tr><td>แคมเปญที่ใช้</td><td>{{ $current->campaigns_used }}</td></tr>
        <tr><td>Commercial 30,000</td><td>{{ $current->is_commercial_30000 ? 'ใช่' : 'ไม่' }}</td></tr>
        <tr><td>แต่ง (มูลค่า)</td><td>{{ $current->decoration_amount }}</td></tr>
        <tr><td>เกินแคมเปญ</td><td>{{ $current->over_campaign_amount }} ({{ $current->over_campaign_status }})</td></tr>
        <tr><td>เกินของแต่ง</td><td>{{ $current->over_decoration_amount }} ({{ $current->over_decoration_status }})</td></tr>
        <tr><td>สาเหตุขอเกิน</td><td>{{ $current->over_reason }}</td></tr>
    </table>

    <div class="section-title">ลายเซ็น</div>
    <table>
        <tr>
            <td>SC</td>
            <td>
                @if($current->sc_signature)
                    <img src="{{ public_path(str_replace('storage/', 'storage/', $current->sc_signature)) }}" 
                        style="max-width:200px;">
                @endif
            </td>
        </tr>
        <tr>
            <td>Com การขาย</td>
            <td>
                @if($current->sale_com_signature)
                    <img src="{{ public_path(str_replace('storage/', 'storage/', $current->sale_com_signature)) }}" 
                        style="max-width:200px;">
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
