<div class="table-responsive">
    <table class="table table-bordered">
            <tr class="table-dark"><th colspan="2" class="ps-3">ข้อมูลพื้นฐาน</th></tr>
            <tr><th class="ps-3" style="width: 250px;">วันที่ขอแคมเปญ:</th><td>{{ $current->created_at->format('d/m/Y') }}</td></tr>
            <tr><th class="ps-3">วันที่ส่งมอบรถ (โดยประมาณ):</th><td>{{ $current->delivery_date ?: '-' }}</td></tr>
            <tr><th class="ps-3">ชื่อลูกค้า:</th><td>{{ $current->customer_name }}</td></tr>
            <tr><th class="ps-3">ที่อยู่:</th><td>{{ $current->customer_district }} {{ $current->customer_province }}</td></tr>
            <tr><th class="ps-3">เบอร์โทร:</th><td>{{ $current->customer_phone }}</td></tr>

            <tr class="table-dark"><th colspan="2" class="ps-3">ข้อมูลผู้รับผิดชอบ</th></tr>
            <tr><th class="ps-3">ที่ปรึกษาการขาย (SC):</th><td>{{ $current->sales_name }}</td></tr>
            <tr><th class="ps-3">Com การขาย:</th><td>{{ $current->sale_com_name ?: '-' }}</td></tr>
            
            <tr class="table-dark"><th colspan="2" class="ps-3">ข้อมูลรถและราคา</th></tr>
            <tr><th class="ps-3">รุ่นรถ:</th><td>{{ $current->car_model }}</td></tr>
            <tr><th class="ps-3">สีรถ:</th><td>{{ $current->car_color }}</td></tr>
            <tr><th class="ps-3">ราคา:</th><td class="fw-bold text-danger">{{ number_format($current->car_price, 2) }} บาท</td></tr>
            
            <tr class="table-info"><th colspan="2" class="ps-3">เงื่อนไขการเงิน</th></tr>
            <tr><th class="ps-3">F/N:</th><td>{{ $current->fn }}</td></tr>
            <tr><th class="ps-3">ดาวน์:</th><td>{{ $current->down_percent }}% ({{ number_format($current->down_amount, 2) }} บาท)</td></tr>
            <tr><th class="ps-3">ค่างวด:</th><td>{{ number_format($current->installment_per_month, 2) }} บาท x {{ $current->installment_months }} งวด</td></tr>
            <tr><th class="ps-3">ดอกเบี้ย:</th><td>{{  $current->interest_rate }}% </td></tr>

            <tr class="table-info"><th colspan="2" class="ps-3">รายการเพิ่มเติม</th></tr>
            <tr><th class="ps-3">ของแถม:</th><td>{!! nl2br(e($current->free_items)) !!}</td></tr>
            <tr><th class="ps-3">ของแถมเกิน:</th><td>{!! nl2br(e($current->free_items_over)) !!}</td></tr>
            <tr><th class="ps-3">ซื้อเพิ่ม:</th><td>{!! nl2br(e($current->extra_purchase_items)) !!}</td></tr>
            
            <tr class="table-info"><th colspan="2" class="ps-3">แคมเปญ</th></tr>
            <tr><th class="ps-3">แคมเปญที่มี:</th><td>{!! nl2br(e($current->campaigns_available)) !!}</td></tr>
            <tr><th class="ps-3">แคมเปญที่ใช้:</th><td>{!! nl2br(e($current->campaigns_used)) !!}</td></tr>
            <tr><th class="ps-3">รวมทั้งหมด:</th><td>{{ number_format($current->decoration_amount, 2) }} บาท</td></tr>
            <tr><th class="ps-3">หมายเหตุ:</th><td>{{ $current->remark ?: '-' }}</td></tr>
    </table>
</div>