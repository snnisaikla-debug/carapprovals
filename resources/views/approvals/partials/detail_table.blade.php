<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered table-striped">
            <tr><th class="bg-light" width="40%">รุ่นรถ</th><td>{{ $approval->car_model }}</td></tr>
            <tr><th class="bg-light">ราคารถ</th><td class="text-danger fw-bold">{{ number_format($approval->car_price, 2) }}</td></tr>
            <tr><th class="bg-light">เงินดาวน์</th><td>{{ number_format($approval->down_amount, 2) }} ({{ $approval->down_percent }}%)</td></tr>
            <tr><th class="bg-light">ยอดจัด</th><td>{{ number_format($approval->finance_amount, 2) }}</td></tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered table-striped">
            <tr><th class="bg-light" width="40%">ค่างวด</th><td>{{ number_format($approval->installment_per_month, 2) }}</td></tr>
            <tr><th class="bg-light">จำนวนงวด</th><td>{{ $approval->installment_months }} งวด</td></tr>
            <tr><th class="bg-light">ดอกเบี้ย</th><td>{{ $approval->interest_rate }}%</td></tr>
            <tr><th class="bg-light">แคมเปญที่ใช้</th><td>{{ $approval->campaigns_used }}</td></tr>
        </table>
    </div>
    <div class="col-12 mt-2">
        <label class="fw-bold">รายการของแถม:</label>
        <div class="p-2 border bg-light rounded" style="min-height: 50px;">
            {!! nl2br(e($approval->free_items)) !!}
        </div>
    </div>
</div>