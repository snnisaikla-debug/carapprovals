<!DOCTYPE html>
<html lang="th">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ใบอนุมัติการขายรถ #{{ $approval->id }}</title>
    <style>
        /* กำหนดฟอนต์ภาษาไทย (ต้องมีไฟล์ฟอนต์ใน storage/fonts) */
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ storage_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ storage_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew', sans-serif;
            font-size: 16pt;
            line-height: 1.2;
        }

        h2 { font-size: 20pt; text-align: center; margin-bottom: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 5px; vertical-align: top; }
        th { background-color: #f2f2f2; font-weight: bold; width: 30%; text-align: left; }
        
        .header-section { background-color: #333; color: white; padding: 5px; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .price { color: red; font-weight: bold; }
        
        /* ลายเซ็น */
        .signature-box { margin-top: 30px; text-align: center; float: left; width: 45%; }
        .signature-img { max-height: 60px; display: block; margin: 0 auto; }
    </style>
</head>
<body>

    <h2>ใบขออนุมัติเงื่อนไขการขาย YPB</h2>
    <div style="text-align: right; margin-bottom: 10px;">
        <strong>วันที่ขอแคมเปญ:</strong> {{ $approval->request_date ? $approval->request_date->format('d/m/Y') : '-' }} <br>
        <strong>วันที่จะส่งมอบรถ:</strong> {{ $approval->delivery_date ? \Carbon\Carbon::parse($approval->delivery_date)->format('d/m/Y H:i') : '-' }}
    </div>

    <div class="header-section">1. ข้อมูลลูกค้าและการขาย</div>
    <table>
        <tr>
            <th>ชื่อลูกค้า</th>
            <td>{{ $approval->customer_name }}</td>
        </tr>
        <tr>
            <th>ที่อยู่</th>
            <td>{{ $approval->customer_address ?? '-' }}</td>
        </tr>
        <tr>
            <th>เบอร์โทร</th>
            <td>{{ $approval->customer_phone ?? '-' }}</td>
        </tr>
        <tr>
            <th>ที่ปรึกษาการขาย (SC)</th>
            <td>{{ $approval->sales_name }}</td>
        </tr>
    </table>

    <div class="header-section">2. ข้อมูลรถและราคา</div>
    <table>
        <tr>
            <th>รุ่นรถ (Model)</th>
            <td>{{ $approval->car_model }}</td>
        </tr>
        <tr>
            <th>ราคารถ</th>
            <td class="price">{{ number_format($approval->car_price, 2) }} บาท</td>
        </tr>
    </table>

    <div class="header-section">3. ของแถมและอุปกรณ์ตกแต่ง</div>
    <table>
        <tr>
            <th>รายการของแถม</th>
            <td>{!! nl2br(e($approval->free_items)) !!}</td>
        </tr>
        <tr>
            <th>งบอุปกรณ์ตกแต่ง</th>
            <td>{{ number_format($approval->decoration_amount, 2) }} บาท</td>
        </tr>
    </table>

    <div style="margin-top: 20px;">
        <div class="signature-box">
            @if($approval->sc_signature_data)
                <img src="{{ $approval->sc_signature_data }}" class="signature-img">
            @else
                <br><br><br>
            @endif
            __________________________<br>
            ( {{ $approval->sales_name }} )<br>
            ผู้เสนอขาย
        </div>

        <div class="signature-box" style="float: right;">
             <br><br><br>
            __________________________<br>
            ( ........................ )<br>
            ผู้อนุมัติ
        </div>
    </div>

</body>
</html>