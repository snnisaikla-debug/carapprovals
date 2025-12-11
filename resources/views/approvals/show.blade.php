@extends('layout')

@section('title', 'ประวัติใบอนุมัติ')

@section('content')
    <h4>ประวัติใบอนุมัติ Group {{ $current->group_id }}</h4>

    <a href="{{ route('approvals.index') }}" class="btn btn-secondary mb-3">ย้อนกลับ</a>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Version</th>
                <th>สถานะ</th>
                <th>ผู้สร้าง</th>
                <th>วันที่สร้าง</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($versions as $v)
                <tr @if($v->id == $current->id) class="table-info" @endif>
                    <td>{{ $v->version }}</td>
                    <td>{{ $v->status }}</td>
                    <td>{{ $v->created_by }}</td>
                    <td>{{ $v->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card mt-3">
        <div class="card-body">
            <h5>ข้อมูลเวอร์ชันล่าสุด (v{{ $current->version }})</h5>
            <p>รุ่นรถ: {{ $current->car_model }}</p>
            <p>ราคา: {{ $current->car_price }}</p>
            <p>ลูกค้า: {{ $current->customer_name }}</p>
            <p>หมายเหตุ: {{ $current->remark }}</p>
            <p>สถานะปัจจุบัน: <strong>{{ $current->status }}</strong></p>
        </div>
    </div>

    @if ($current->status === 'WAIT_ADMIN' && auth()->user()->role === 'ADMIN')
        <div class="mt-3">
            <h5>โหมด Admin (ลองกดเล่น)</h5>
            <form method="POST" action="{{ route('approvals.adminAction', $current->group_id) }}" class="d-inline">
                @csrf
                <input type="hidden" name="action" value="approve">
                <button class="btn btn-success">Admin อนุมัติ ➜ ส่งให้หัวหน้า</button>
            </form>

            <form method="POST" action="{{ route('approvals.adminAction', $current->group_id) }}" class="d-inline">
                @csrf
                <input type="hidden" name="action" value="reject">
                <button class="btn btn-danger">Admin ไม่อนุมัติ</button>
            </form>
        </div>
    @endif

    @if ($current->status === 'WAIT_HEAD' && auth()->user()->role === 'HEAD')
        <div class="mt-3">
            <h5>โหมดหัวหน้า (ลองกดเล่น)</h5>
            <form method="POST" action="{{ route('approvals.headAction', $current->group_id) }}" class="d-inline">
                @csrf
                <input type="hidden" name="action" value="approve">
                <button class="btn btn-success">หัวหน้าอนุมัติ ➜ APPROVED</button>
            </form>

            <form method="POST" action="{{ route('approvals.headAction', $current->group_id) }}" class="d-inline">
                @csrf
                <input type="hidden" name="action" value="reject">
                <button class="btn btn-danger">หัวหน้าไม่อนุมัติ</button>
            </form>
        </div>
    @endif
    <div class="card mt-3">
    <div class="card-body">
        <h5>ลายเซ็น</h5>
        @if($current->sc_signature)
            <p>SC:</p>
            <img src="{{ asset($current->sc_signature) }}" alt="SC Signature" style="max-width:200px;">
        @endif

        @if($current->sale_com_signature)
            <p>Com การขาย:</p>
            <img src="{{ asset($current->sale_com_signature) }}" alt="Sale Com Signature" style="max-width:200px;">
        @endif
    </div>
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
@endsection
        <a href="{{ route('approvals.pdf', $current->group_id) }}"
   class="fab-download">
    PDF
</a>

