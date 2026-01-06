@extends('layout')

@section('title', 'รายละเอียดใบอนุมัติ Group ' . $current->group_id)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">ประวัติใบอนุมัติ Group {{ $current->group_id }}</h4>
        <a href="{{ route('approvals.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> ย้อนกลับ
        </a>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered table-sm align-middle shadow-sm">
            <thead class="table-light">
                <tr class="text-center">
                    <th style="width: 80px;">Version</th>
                    <th>สถานะ</th>
                    <th>ผู้สร้าง</th>
                    <th>วันที่สร้าง</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approvals as $ver)
                <tr class="text-center {{ $ver->version == $current->version ? 'table-info' : '' }}">
                    <td>{{ $ver->version }}</td>
                    <td><span class="badge {{ $ver->status == 'Approved' ? 'bg-success' : 'bg-primary' }}">{{ $ver->status }}</span></td>
                    <td>{{ $ver->created_by }}</td>
                    <td>{{ $ver->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-body p-0">
    <table class="table table-sm table-striped mb-0">
        <tbody>
            <tr class="table-dark"><th colspan="2" class="ps-3">ข้อมูลพื้นฐาน</th></tr>
            <tr><th class="ps-3" style="width: 250px;">วันที่ขอแคมเปญ:</th><td>{{ $current->created_at->format('d/m/Y') }}</td></tr>
            <tr><th class="ps-3">วันที่ส่งมอบรถ (โดยประมาณ):</th><td>{{ $current->delivery_date ?: '-' }}</td></tr>
            <tr><th class="ps-3">ชื่อลูกค้า:</th><td>{{ $current->customer_name }}</td></tr>
            
            <tr class="table-dark"><th colspan="2" class="ps-3">ข้อมูลผู้รับผิดชอบ</th></tr>
            <tr><th class="ps-3">ที่ปรึกษาการขาย (SC):</th><td>{{ $current->sales_name }}</td></tr>
            <tr><th class="ps-3">Com การขาย:</th><td>{{ $current->sale_com_name ?: '-' }}</td></tr>
            
            <tr class="table-dark"><th colspan="2" class="ps-3">ข้อมูลรถและราคา</th></tr>
            <tr><th class="ps-3">รุ่นรถ:</th><td>{{ $current->car_model }}</td></tr>
            <tr><th class="ps-3">สีรถ:</th><td>{{ $current->car_color }}</td></tr>
            <tr><th class="ps-3">ราคา:</th><td class="fw-bold text-danger">{{ number_format($current->car_price, 2) }} บาท</td></tr>
            
            <tr class="table-secondary"><th colspan="2" class="ps-3">เงื่อนไขการเงิน</th></tr>
            <tr><th class="ps-3">ดาวน์:</th><td>{{ $current->down_percent }}% ({{ number_format($current->down_amount, 2) }} บาท)</td></tr>
            <tr><th class="ps-3">ค่างวด:</th><td>{{ number_format($current->installment_per_month, 2) }} บาท x {{ $current->installment_months }} งวด</td></tr>
            
            <tr class="table-secondary"><th colspan="2" class="ps-3">รายการเพิ่มเติม</th></tr>
            <tr><th class="ps-3">ของแถม/แคมเปญ:</th><td>{!! nl2br(e($current->free_items)) !!}</td></tr>
            <tr><th class="ps-3">หมายเหตุ:</th><td>{{ $current->remark ?: '-' }}</td></tr>
        </tbody>
    </table>
</div>
<style>
.fab-download {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #b91c1c;   /* แดงเข้ม */
    color: white;
    border-radius: 50px;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    z-index: 999;
}
.fab-download:hover {
    background-color: #dc2626;   /* แดงสว่างขึ้นตอน hover */
    color: #fff;
}
</style>
    <a href="{{ route('approvals.pdf', $current->id) }}"
        class="fab-download text-decoration-none">
    Export PDF
    </a>
@endsection

