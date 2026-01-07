@extends('layout')

@section('title', 'รายการใบอนุมัติ')

@section('content')

@php
    // แยก Draft ออกเป็นอีกตาราง
    $draftApprovals = $approvals->where('status', 'Draft');
    // ตารางหลักแสดงเฉพาะที่ไม่ใช่ Draft
    $mainApprovals  = $approvals->where('status', '!=', 'Draft');
@endphp

{{-- แถว 1: ปุ่มสร้าง --}}
    @if(Auth::user()->role == 'sale')
        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('approvals.create') }}" class="btn btn-success">
                + สร้างใบอนุมัติใหม่
            </a>
        </div>
    @endif

{{-- แถว 2: ตัวกรอง + เรียงวันที่ --}}
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <form action="{{ route('approvals.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-wrap">
        <select name="sales_user_id" class="form-select form-select-sm" style="width:160px" onchange="this.form.submit()">
            <option value="">-- ทั้งหมด --</option>
            @foreach($salesList as $id => $name)
                <option value="{{ $id }}" {{ request('sales_user_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>

        <select name="status" class="form-select form-select-sm" style="width:180px" onchange="this.form.submit()">
            <option value="">-- ทุกสถานะ --</option>
            @foreach ($statusList as $st)
                <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
            @endforeach
        </select>
        <input type="hidden" name="sort" value="{{ request('sort','newest') }}">
    </form>

    <div class="d-flex align-items-center gap-2">
        @php
            $currentSort = request('sort','newest');
            $toggleSort = $currentSort === 'newest' ? 'oldest' : 'newest';
            $toggleText = $currentSort === 'newest' ? 'เรียงวันที่: ล่าสุด' : 'เรียงวันที่: เก่าสุด';
        @endphp
        <a href="{{ route('approvals.index', ['sort' => $toggleSort, 'sales_user_id' => request('sales_user_id'), 'status' => request('status')]) }}" class="btn btn-sm btn-outline-primary">
            {{ $toggleText }}
        </a>
    </div>
</div>

{{-- แถว 3: ตารางหลัก (ใช้ $mainApprovals) --}}
<div class="table-responsive">
    <table class="table table-bordered table-sm align-middle">
        <thead class="text-center bg-light">
            <tr>
                <th style="width:40px">#</th>
                <th style="width:90px">GroupID</th>
                <th>รุ่นรถ</th>
                <th>ชื่อผู้ส่งคำขอ</th>
                <th style="width:160px">สถานะ</th>
                <th style="width:170px">อัปเดตล่าสุด</th>
                <th style="width:260px">จัดการ</th>
            </tr>
        </thead>
        <tbody>
        @forelse($mainApprovals as $approval) {{-- แก้จาก $approvals เป็น $mainApprovals เพื่อไม่ให้โชว์ซ้ำกับตาราง Draft --}}
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $approval->group_id }}</td> {{-- แก้จาก $row เป็น $approval --}}
                <td>{{ $approval->car_model }}</td> 
                <td>{{ $approval->sales_name }}</td>
                <td class="text-center">
                    @if($approval->status == 'Pending_Admin')
                        <span class="badge px-3 py-2" style="background-color: #fd178aff; color: white;">Pending Admin</span> {{-- สีชมพู --}}
                    @elseif($approval->status == 'Pending_Manager')
                        <span class="badge px-3 py-2" style="background-color: #ff6716ff; color: white;">Pending Manager</span> {{-- สีส้ม--}}
                    @elseif($approval->status == 'Approved')
                        <span class="badge px-3 py-2" style="background-color: #03b11aff; color: white;">Approved</span> {{-- สีเขียว --}}
                    @elseif($approval->status == 'Draft')
                        <span class="badge px-3 py-2" style="background-color: #f7ff07ff; color: black;">Draft</span> {{-- สีเหลือง --}}
                    @elseif($approval->status == 'Reject')
                        <span class="badge px-3 py-2" style="background-color: #fe1c1cff; color: white;">Rejected</span> {{-- สีแดง --}}
                    @else
                        <span class="badge bg-dark px-3 py-2">{{ $approval->status }}</span>
                    @endif
                </td>
                <td class="text-center text-muted small">{{ $approval->updated_at }}</td>
                <td class="text-center">
                    @php $role = strtolower(Auth::user()->role); @endphp
                    @if($role == 'admin')
                        @include('approvals.partials.actions_admin', ['approval' => $approval])
                    @elseif($role == 'manager')
                        @include('approvals.partials.actions_manager', ['approval' => $approval])
                    @elseif($role == 'sale')
                        @include('approvals.partials.actions_sale', ['approval' => $approval])
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted p-4">ไม่มีรายการที่รอดำเนินการ</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- ตาราง Draft แยกด้านล่าง --}}
@if($draftApprovals->count())
    <hr class="my-5">
    <h6 class="fw-bold mb-3 text-secondary"><i class="bi bi-file-earmark-text"></i> งานสถานะ Draft (ยังไม่ได้ส่งอนุมัติ)</h6>
    <div class="table-responsive">
        <table class="table table-sm table-hover align-middle border">
            <thead class="table-light text-center">
                <tr>
                    <th style="width:40px">#</th>
                    <th style="width:90px">GroupID</th>
                    <th>รุ่นรถ</th>
                    <th>ชื่อผู้ส่งคำขอ</th>
                    <th style="width:160px">สถานะ</th>
                    <th style="width:170px">สร้างเมื่อ</th>
                    <th style="width:200px">จัดการ</th>
                </tr>
            </thead>
            <tbody>
            @foreach($draftApprovals as $approval) {{-- ใช้ $approval เพื่อให้ตรงกับ partials --}}
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $approval->group_id }}</td>
                    <td class="text-center">{{ $approval->car_model }}</td>
                    <td class="text-center">{{ $approval->sales_name }}</td>
                    <td class="text-center">
                        @php $role = strtolower(Auth::user()->role); @endphp
                        @if($role == 'admin')
                            @include('approvals.partials.actions_admin', ['approval' => $approval])
                        @elseif($role == 'manager')
                            @include('approvals.partials.actions_manager', ['approval' => $approval])
                        @elseif($role == 'sale')
                            @include('approvals.partials.actions_sale', ['approval' => $approval])
                        @endif
                    </td>
                    <td class="text-center text-muted small">{{ $approval->created_at }}</td>
                    <td class="text-center">
                        @include('approvals.partials.actions_sale', ['approval' => $approval])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection