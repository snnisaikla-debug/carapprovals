@extends('layout')

@section('title', 'รายการใบอนุมัติ')

@section('content')

@php
    // แยก Draft ออกเป็นอีกตาราง (ใช้ชุดเดียวกับ approvals ที่โชว์ใน index)
    $draftApprovals = $approvals->where('status', 'Draft');
    $mainApprovals  = $approvals->where('status', '!=', 'Draft');
@endphp

{{-- แถว 1: ปุ่มสร้าง (ชิดซ้ายบนสุด) --}}
<div class="d-flex justify-content-start mb-3">
    <a href="{{ route('approvals.create') }}" class="btn btn-success">
        + สร้างใบอนุมัติใหม่
    </a>
</div>

{{-- แถว 2: ตัวกรอง + เรียงวันที่ --}}
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

    <form action="{{ route('approvals.index') }}" 
        method="GET" 
        class="d-flex align-items-center gap-2 flex-wrap">
       
        {{-- Sales --}}
        <select name="sales_user_id" 
        class="form-select form-select-sm" 
        style="width:160px" 
        onchange="this.form.submit()">
            <option value="">-- ทั้งหมด --</option>
        @foreach($salesList as $id => $name)
            <option value="{{ $id }}" {{ request('sales_user_id') == $id ? 'selected' : '' }}>
            {{ $name }}
            </option>
        @endforeach
        </select>

        {{-- Status --}}
        <select name="status" class="form-select form-select-sm" style="width:180px" onchange="this.form.submit()">
            <option value="">-- ทุกสถานะ --</option>
            @foreach ($statusList as $st)
                <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                    {{ $st }}
                </option>
            @endforeach
        </select>

        {{-- เก็บ sort เดิมไว้ตอนเปลี่ยน filter --}}
        <input type="hidden" name="sort" value="{{ request('sort','newest') }}">
    </form>

    {{-- เรียงวันที่ (แยกไว้ขวา) --}}
    <div class="d-flex align-items-center gap-2">
        <span class="small text-muted"></span>

        @php
            $currentSort = request('sort','newest');
            $toggleSort = $currentSort === 'newest' ? 'oldest' : 'newest';
            $toggleText = $currentSort === 'newest' ? 'เรียงวันที่: ล่าสุด' : 'เรียงวันที่: เก่าสุด';
        @endphp

        <a href="{{ route('approvals.index', [
                'sort' => $toggleSort,
                'sales' => request('sales'),
                'status' => request('status'),
            ]) }}"
           class="btn btn-sm btn-outline-primary">
            {{ $toggleText }}
        </a>
    </div>

</div>

{{-- แถว 3: ตารางหลัก (ไม่รวม Draft) --}}
<div class="table-responsive">
    <table class="table table-bordered table-sm align-middle">
        <thead class="text-center">
            <tr>
                <th style="width:40px">#</th>
                <th style="width:90px">GroupID</th>
                <th>รุ่นรถ</th>
                <th>ชื่อผู้ส่งคำขอ</th>
                <th style="width:160px">สถานะ</th>
                <th style="width:170px">อัปเดตล่าสุด</th>
                <th style="width:260px"></th>
            </tr>
        </thead>
        <tbody>
        @forelse($mainApprovals as $row)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $row->group_id }}</td>
                <td>{{ $row->car_model }}</td>
                <td>{{ $row->sales_name }}</td>
                <td class="text-center">{{ $row->status }}</td>
                <td class="text-center">{{ $row->updated_at }}</td>

                <td>
                    @if(strtolower(Auth::user()->role) == 'admin')
                        @include('partials.action_admin')
                    @elseif(strtolower(Auth::user()->role) == 'manager')
                        @include('partials.action_manager')
                    @elseif(strtolower(Auth::user()->role) == 'sale')
                        @include('partials.action_sale')
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted">ไม่มีรายการ</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- ตาราง Draft แยกด้านล่าง --}}
@if($draftApprovals->count())
    <hr class="my-4">

    <h6 class="fw-bold mb-2">งานสถานะ Draft</h6>

    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="text-center">
                <tr>
                    <th style="width:40px">#</th>
                    <th style="width:90px">GroupID</th>
                    <th>รุ่นรถ</th>
                    <th>ชื่อผู้ส่งคำขอ</th>
                    <th style="width:160px">สถานะ</th>
                    <th style="width:170px">อัปเดตล่าสุด</th>
                    <th style="width:260px"></th>
                </tr>
            </thead>
            <tbody>
            @foreach($draftApprovals as $row)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $row->group_id }}</td>
                    <td>{{ $row->car_model }}</td>
                    <td>{{ $row->sales_name }}</td>
                    <td class="text-center">{{ $row->status }}</td>
                    <td class="text-center">{{ $row->updated_at }}</td>

                    <td class="text-nowrap text-center">
                        @if(auth()->user()->role === 'sale')
                            @include('approvals.partials.actions_sale', ['row' => $row])
                        @elseif(auth()->user()->role === 'admin')
                            @include('approvals.partials.actions_admin', ['row' => $row])
                        @else
                            @include('approvals.partials.actions_head', ['row' => $row])
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection
