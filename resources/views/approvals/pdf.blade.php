<!DOCTYPE html>
<html lang="th">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>ใบขออนุมัติเงื่อนไขการขาย #{{ $approval->id }}</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            src: url("{{ storage_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew', sans-serif;
            font-size: 16px;
            margin: 0;
            padding: 0;
            line-height: 1.1; /* ลดช่องว่างระหว่างบรรทัดลงนิดหน่อยให้พอดีหน้า */
        }

        @page {
            size: A4;
            margin: 1cm;
        }

        .container {
            width: 100%;
        }

        .header-title {
            font-weight: bold;
            font-size: 20px;
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* บังคับให้ขนาดตารางคงที่ ไม่ตกขอบ */
        }

        td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .bordered td, .bordered th {
            border: 1px solid black;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }

        .dotted-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 50px;
        }

        .sale-type-section {
            border: 1px solid black;
            padding: 5px;
            margin: 5px 0;
        }
    </style>
</head>

<body>
<div class="container">
    @php
        $selectedTypes = is_array($approval->sale_type_options) 
            ? $approval->sale_type_options 
            : json_decode($approval->sale_type_options ?? '[]', true);
    @endphp

    <table style="margin-bottom: 10px;">
        <tr>
            <td width="40%"><span class="header-title">ใบขออนุมัติเงื่อนไขการขาย YPB</span></td>
            <td width="60%" class="text-right">
                วันที่ขอแคมเปญ: <span class="dotted-line">{{ $approval->request_date ?? '-' }}</span> 
                วันที่ส่งมอบรถ: <span class="dotted-line">{{ $approval->delivery_date ?? '-' }}</span>
            </td>
        </tr>
    </table>

    <table style="margin-bottom: 10px;">
        <tr>
            <td width="70%" style="border-right: 0.5px solid #eee;">
                รุ่นรถ: <span class="dotted-line">{{ $approval->car_model ?? '-' }}</span> 
                ออฟชั่น: <span class="dotted-line">{{ $approval->car_options ?? '-' }}</span><br>
                สี: <span class="dotted-line">{{ $approval->car_color ?? '-' }}</span>
                ราคา: <span class="dotted-line">{{ number_format($approval->car_price ?? 0) }}</span> บาท<br> 
                บวกหัว: <span class="dotted-line">{{ number_format($approval->plus_head ?? 0) }}</span> บาท
                F/N: <span class="dotted-line">{{ $approval->fn ?? '-' }}</span><br> 
                ดาวน์: <span class="dotted-line">{{ $approval->down_percent ?? '-' }}</span>% 
                ยอด: <span class="dotted-line">{{ number_format($approval->down_amount ?? 0) }}</span> บาท<br>
                ยอดจัด: <span class="dotted-line">{{ number_format($approval->finance_amount ?? 0) }}</span> บาท 
                งวดละ: <span class="dotted-line">{{ number_format($approval->installment_per_month ?? 0) }}</span> บาท<br>
                จำนวน: <span class="dotted-line">{{ $approval->installment_months ?? '-' }}</span> งวด 
                ดอกเบี้ย: <span class="dotted-line">{{ $approval->interest_rate ?? '-' }}</span> %<br>
                คัชซี: <span class="dotted-line">{{ $approval->Chassis ?? '-' }}</span>
                เลขสต๊อก: <span class="dotted-line">{{ $approval->stock_number ?? '-' }}</span>
            </td>
            <td width="60%" style="border-right: 0.5px solid #eee;">
                รหัสแคมเปญ: <span class="dotted-line">{{ $approval->com_fn_option ?? '-' }}</span> 
                หัก: <span class="dotted-line">{{ number_format($approval->Flight ?? 0) }}</span> บาท
                
                <div class="sale-type-section">
                    <span class="bold">ประเภทการขาย</span><br>
                    [{{ in_array('GE', $selectedTypes ?? []) ? '✓' : ' ' }}] GE จำนวน <b>{{ number_format($approval->amount_ge ?? 0) }}</b> บาท<br>
                    [{{ in_array('RETENTION', $selectedTypes ?? []) ? '✓' : ' ' }}] Retention จำนวน <b>{{ number_format($approval->amount_retention ?? 0) }}</b> บาท<br>
                    [{{ in_array('FARMER', $selectedTypes ?? []) ? '✓' : ' ' }}] เกษตรกร จำนวน <b>{{ number_format($approval->amount_farmer ?? 0) }}</b> บาท<br>
                    [{{ in_array('Welcome', $selectedTypes ?? []) ? '✓' : ' ' }}] Welcome จำนวน <b>{{ number_format($approval->amount_welcome ?? 0) }}</b> บาท
                </div>

                <span>[{{ in_array('options5', $selectedTypes ?? []) ? '✓' : ' ' }}] Fleet จำนวน<b>{{ number_format($approval->fleet_amount ?? 0) }}</span> บาท<br> 
                หักประกัน: <span class="dotted-line">{{ number_format($approval->insurance_deduct ?? 0) }}</span> บาท
                ใช้จริง: <span class="dotted-line">{{ number_format($approval->insurance_used ?? 0) }}</span> บาท<br>
                Kickback: <span class="dotted-line">{{ number_format($approval->kickback_amount ?? 0) }}</span> บาท<br>
                Com F/N: <span class="dotted-line">{{ $approval->com_option ?? '-' }}</span>
                จำนวน: <span>{{ number_format($approval->com_fn_amount ?? 0) }}</span> บาท<br>
            </td>
        </tr>
    </table>

    <table class="bordered">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th width="33%">รายการของแถม</th>
            <th width="33%">รายการของแถมเกิน</th>
            <th width="34%">รายการซื้อเพิ่ม</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td height="150">
                {{-- วนลูปแสดงรายการของแถม --}}
                @foreach($items as $index => $item)
                    <div>{{ $index + 1 }}. {{ trim($item) }}</div>
                @endforeach
            </td>
            <td>
                {{-- สำหรับรายการของแถมเกิน (ถ้ามี) --}}
                @php
                    $itemsOver = array_filter(explode("\n", $approval->free_items_over));
                @endphp
                @foreach($itemsOver as $index => $itemOver)
                    <div>{{ $index + 1 }}. {{ trim($itemOver) }}</div>
                @endforeach
            </td>
            <td>
                {{-- สำหรับรายการซื้อเพิ่ม --}}
                @php
                    $extras = array_filter(explode("\n", $approval->extra_purchase_items));
                @endphp
                @foreach($extras as $extra)
                    <div style="display: flex; justify-content: space-between;">
                        <span>{{ trim($extra) }}</span>
                    </div>
                @endforeach
            </td>
        </tr>
    </tbody>
</table>

<table class="bordered" style="margin-top: 10px;">
    <tr class="text-center bold" style="background-color: #f2f2f2;">
        <td width="33%">แคมเปญที่มี</td>
        <td width="33%">แคมเปญที่ใช้</td>
        <td width="34%">[{{ ($approval->is_commercial_30000 == 1) ? '✓' : ' ' }}] Commercial 30,000 บาท</td>
    </tr>
    <tr>
        <td height="100">
            {{-- วนลูปแสดงแคมเปญที่มี --}}
            @foreach($campaignsAvailable ?? [] as $camp)
                <div>{{ trim($camp) }}</div>
            @endforeach
        </td>
        <td>
            {{-- วนลูปแสดงแคมเปญที่ใช้ --}}
           @foreach($campaignsUsed ?? [] as $used)
                <div>{{ trim($used) }}</div>
            @endforeach
        </td>
        <td>
            {{-- ส่วนรายการแต่ง --}}
           @php
                $decorations = array_filter(explode("\n", $approval->decoration_list ?? ''));
                $values = array_filter(explode("\n", $approval->decoration_value ?? ''));
            @endphp
            <table style="border: none; width: 100%;">
                @foreach($decorations as $index => $dec)
                <tr>
                    <td style="border: none; padding: 0;">{{ trim($dec) }}</td>
                    <td style="border: none; padding: 0;" class="text-right">{{ trim($values[$index] ?? '-') }}</td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>

<table style="margin-top: 10px;">
    <tr>
        <td>
            เกินแคมเปญมูลค่า <span class="dotted-line">{{ $approval->over_campaign_amount ?? '-' }}</span> บาท
            เกินของตกแต่งมูลค่า <span class="dotted-line">{{ $approval->over_decoration_amount ?? '-' }}</span> บาท
            SC <span class="dotted-line">{{ $approval->sc_signature ?? '-' }}</span>
            Com การขาย <span class="dotted-line">{{ $approval->sale_com_signature ?? '-' }}</span>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td>
            สาเหตุขอเกิน <span class="dotted-line">{{ $approval->over_reason ?? '-' }}</span>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td>
            ชื่อลูกค้า <span class="dotted-line">{{ $approval->customer_name }}</span>
        </td>
        <td>
            ที่อยู่ <span class="dotted-line">{{ $approval->customer_address }} {{ $approval->customer_subdistrict }} {{ $approval->customer_district }} {{ $approval->customer_province }}</span>
        </td>
        <td>
            เบอร์โทร <span class="dotted-line">{{ $approval->customer_phone }}</span>
        </td>
    </tr>
</table>
    <table style="margin-top: 10px;" class="text-center">
        <tr>
            <td>
                <br><br>
                ....................................................<br>
                ผู้ขออนุมัติ
            </td>
            <td>
                <br><br>
                ....................................................<br>
                ที่ปรึกษาการขาย
            </td>
        </tr>
    </table>
</div>
</body>
</html>