<div class="card mt-4">
    <div class="card-header bg-warning text-black">
        <strong>ตัวอย่างเอกสาร V.{{ $approval->version }}</strong>
    </div>
   
        <table class="table table-bordered">
            <tr><th class="ps-3">หมายเหตุ:</th><td>{{ $approval->remark ?: '-' }}</td></tr>
            <tr class="table-dark"><th colspan="2" class="ps-3">ข้อมูลพื้นฐาน</th></tr>
            <tr><th class="ps-3" style="width: 250px;">วันที่ขอแคมเปญ:</th><td>{{ $approval->created_at->format('d/m/Y') }}</td></tr>
            <tr><th class="ps-3">วันที่ส่งมอบรถ (โดยประมาณ):</th><td>{{ $approval->delivery_date ?: '-' }}</td></tr>
            <tr><th class="ps-3">ชื่อลูกค้า:</th><td>{{ $approval->customer_name }}</td></tr>
            <tr><th class="ps-3">ที่อยู่:</th><td>{{ $approval->customer_address }} {{ $approval->customer_subdistrict }} {{ $approval->customer_district }} {{ $approval->customer_province }}</td></tr>
            <tr><th class="ps-3">เบอร์โทร:</th><td>{{ $approval->customer_phone }}</td></tr>
            <tr><th class="ps-3">อีเมล:</th><td>{{ $approval->customer_email }}</td></tr>

            <tr class="table-dark"><th colspan="2" class="ps-3">ข้อมูลผู้รับผิดชอบ</th></tr>
            <tr><th class="ps-3">ที่ปรึกษาการขาย (SC):</th><td>{{ $approval->sales_name }}</td></tr>
            <tr><th class="ps-3">Com การขาย:</th><td>{{ $approval->sale_com_name ?: '-' }}</td></tr>
                    
            <tr class="table-dark"><th colspan="2" class="ps-3">ข้อมูลรถและราคา</th></tr>
            <tr><th class="ps-3">รุ่นรถ:</th><td>{{ $approval->car_model }}</td></tr>
            <tr><th class="ps-3">สีรถ:</th><td>{{ $approval->car_color }}</td></tr>
            <tr><th class="ps-3">ราคา:</th><td class="fw-bold text-danger">{{ number_format($approval->car_price, 2) }} บาท</td></tr>
                    
            <tr class="table-info"><th colspan="2" class="ps-3">เงื่อนไขการเงิน</th></tr>
            <tr><th class="ps-3">F/N:</th><td>{{ $approval->fn }}</td></tr>
            <tr><th class="ps-3">ดาวน์:</th><td>{{ $approval->down_percent }}% ({{ number_format($approval->down_amount, 2) }} บาท)</td></tr>
            <tr><th class="ps-3">ค่างวด:</th><td>{{ number_format($approval->installment_per_month, 2) }} บาท x {{ $approval->installment_months }} งวด</td></tr>
            <tr><th class="ps-3">ดอกเบี้ย:</th><td>{{  $approval->interest_rate }}% </td></tr>

            <tr class="table-info"><th colspan="2" class="ps-3">รายการเพิ่มเติม</th></tr>
            <tr><th class="ps-3">ของแถม:</th><td>{!! nl2br(e($approval->free_items)) !!}</td></tr>
            <tr><th class="ps-3">ของแถมเกิน:</th><td>{!! nl2br(e($approval->free_items_over)) !!}</td></tr>
            <tr><th class="ps-3">ซื้อเพิ่ม:</th><td>{!! nl2br(e($approval->extra_purchase_items)) !!}</td></tr>
                    
            <tr class="table-info"><th colspan="2" class="ps-3">แคมเปญ</th></tr>
            <tr><th class="ps-3">แคมเปญที่มี:</th><td>{!! nl2br(e($approval->campaigns_available)) !!}</td></tr>
            <tr><th class="ps-3">แคมเปญที่ใช้:</th><td>{!! nl2br(e($approval->campaigns_used)) !!}</td></tr>
            <tr><th class="ps-3">รวมทั้งหมด:</th><td>{{ number_format($approval->decoration_amount, 2) }} บาท</td></tr>
        </table>
    </div>