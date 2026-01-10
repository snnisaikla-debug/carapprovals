@extends('layout')

@section ('title', 'รายละเอียดใบอนุมัติ ')

@section('content')
<div class="card mb-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">ประวัติใบอนุมัติ Group {{ $current->group_id }}</h5>
        
        <a href="{{ route('approvals.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> ย้อนกลับ
        </a>
    </div>
<style>
    .table-info {
        background-color: #5be1edff !important; /* สีฟ้าอ่อนสำหรับแถวที่เลือก */
    }                                                                                                                                                                                       
    .table-hover tbody tr:hover {
        background-color: #2f6295ff; /* สีเมื่อเอาเมาส์ไปชี้ */
    }
    .badge {
        padding: 8px 12px;
        border-radius: 6px;
        color: white;
    }
</style>
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
                <tr class="clickable-row {{ $ver->group_id == $current->group_id  ? 'table-info' : '' }}" 
                    data-href="{{ route('approvals.show', $ver->group_id ) }}" style="cursor: pointer;">
                    <td>{{ $ver->ver }}</td>
                    <td class="text-center">
                        @if($ver->status == 'Pending_Admin')
                            <span class="badge px-3 py-2" style="background-color: #fd178aff; color: white;">Pending Admin</span> {{-- สีชมพู --}}
                        @elseif($ver->status == 'Pending_Manager')
                            <span class="badge px-3 py-2" style="background-color: #ff6716ff; color: white;">Pending Manager</span> {{-- สีส้ม--}}
                        @elseif($ver->status == 'Approved')
                            <span class="badge px-3 py-2" style="background-color: #03b11aff; color: white;">Approved</span> {{-- สีเขียว --}}
                        @elseif($ver->status == 'Draft')
                            <span class="badge px-3 py-2" style="background-color: #f7ff07ff; color: black;">Draft</span> {{-- สีเหลือง --}}
                        @elseif($ver->status == 'Reject')
                            <span class="badge px-3 py-2" style="background-color: #fe1c1cff; color: white;">Rejected</span> {{-- สีแดง --}}
                        @else
                            <span class="badge bg-dark px-3 py-2">{{ $ver->status }}</span>
                        @endif
                    </td>
                    <td>{{ $ver->sales_name }}</td>
                    <td>{{ $ver->created_at->format('d/m/Y H:i:s', strtotime($ver->created_at)) }}</td></tr>
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
    <a href="{{ route('approvals.exportPdf', $current->id) }}"
        class="fab-download text-decoration-none">
        Export PDF
    </a>
<script>
    document.querySelectorAll('.clickable-row').forEach(row => {
        row.addEventListener('click', () => {
            window.location.href = row.dataset.href;
        });
    });
</script>
@endsection

