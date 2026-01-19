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
    
        

        /* คลาสสำหรับแบ่งครึ่งหน้า */
        .col-6 {
            width: 48%; /* กว้างเกือบครึ่ง (เผื่อช่องว่างตรงกลาง) */
            float: left; /* ให้ลอยไปทางซ้าย */
        }
        
        /* คลาสสำหรับเว้นระยะห่างตรงกลาง (ถ้ามีคอลัมน์ขวา) */
        .me-2 {
            margin-right: 4%;
        }

        /* สำคัญ! ต้องมีตัวล้าง float เมื่อจบแถว ไม่งั้นเนื้อหาข้างล่างจะพัง */
        .clearfix {
            clear: both;
        }

        /* แต่งตารางให้สวยงาม */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px; /* ปรับขนาดตัวอักษรตามชอบ */
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
            text-align: left;
            width: 30%; /* กำหนดความกว้างหัวข้อ */
        }

    </style>
</head>
<body>

{{-- ---------------------------------------------------------------------------------- --}}

    <h2>ใบขออนุมัติเงื่อนไขการขาย YPB</h2>
    
    <div style="text-align: right; margin-bottom: 10px;">
        <strong>วันที่ขอแคมเปญ:</strong> {{ $approval->request_date ? $approval->request_date->format('d/m/Y') : '-' }} <br>
        <strong>วันที่จะส่งมอบรถ:</strong> {{ $approval->delivery_date ? \Carbon\Carbon::parse($approval->delivery_date)->format('d/m/Y H:i') : '-' }}
    </div>

    {{-- เปิดแถวใหม่ --}}
<div class="row">

    {{-- ตารางครึ่งซ้าย: ข้อมูลลูกค้า --}}
    <div class="col-6 me-2">
        <h4 style="margin-bottom: 5px;">ข้อมูลลูกค้า</h4>
        <table>
            <tr>
                <th>ชื่อลูกค้า</th>
                <td>{{ $approval->customer_name ?? '-' }}</td>
            </tr>
            <tr>
                <th>ที่อยู่</th>
                <td>
                    {{ $approval->customer_district ?? '-' }} 
                    {{ $approval->customer_province ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>เบอร์โทร</th>
                <td>{{ $approval->customer_phone ?? '-' }}</td>
            </tr>
            <tr>
                <th>รุ่นรถ</th>
                <td>{{ $approval->car_model ?? '-' }}</td>
            </tr>
            <tr>
                <th>ออฟชั่น</th>
                <td>{{ $approval->car_options ?? '-' }}</td>
            </tr>
            <tr>
                <th>สี</th>
                <td>{{ $approval->car_color ?? '-' }}</td>
            </tr>
           
            <tr>
                <th>ราคารถ</th>
                <td>{{ number_format($approval->car_price, 2) }}</td>
            </tr>
            
        </table>
    </div>

    {{-- ตารางครึ่งขวา:  (ถ้าไม่ใส่ส่วนนี้ ตารางซ้ายก็จะกินพื้นที่แค่ครึ่งเดียวอยู่ดี) --}}
    <div class="col-6">
        <h4 style="margin-bottom: 5px;">รหัสแคมเปญ</h4>
        <table>
            
        </table>
    </div>

</div>

{{-- ล้าง Float เพื่อให้เนื้อหาส่วนต่อไปขึ้นบรรทัดใหม่ถูกต้อง --}}
<div class="clearfix"></div>

<br>
{{-- เนื้อหาส่วนอื่นต่อจากนี้... --}}
    <div class="header-section">2. ข้อมูลรถและราคา</div>
    <table>
        <tr>
            <th>รุ่นรถ/สี</th>
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
            ________________________<br>
            ( {{ $approval->sales_name }} )<br>
            ผู้เสนอขาย
        </div>

        <div class="signature-box" style="float: right;">
             <br><br><br>
            ________________________<br>
            ( ................................ )<br>
            ผู้อนุมัติ
        </div>
    </div>

</body>
</html>