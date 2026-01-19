@extends('layout')

@section('title', 'รายการใบอนุมัติ')

@section('content')

@php
    $user = Auth::user();
    $isSale = $user->role === 'sale';

    // 1. ตารางหลัก: Admin/Manager เห็นทุกสถานะยกเว้น Draft | Sale เห็นเฉพาะที่ส่งไปแล้ว (Pending/Approved)
    if ($isSale) {
        $mainApprovals = $approvals->whereIn('status', ['Pending_Admin', 'Pending_Manager', 'Approved']);
    } else {
        $mainApprovals = $approvals->where('status', '!=', 'Draft');
    }

    // 2. ตาราง Draft (สำหรับ Sale เท่านั้น): รวมงานที่เป็น Draft จริงๆ และงานที่ถูก Reject
    if ($isSale) {
        $draftApprovals = $approvals->whereIn('status', ['Draft', 'Reject']);
    } else {
        $draftApprovals = collect(); // Admin/Manager ไม่เห็นตารางนี้
    }
@endphp

{{-- แถว 1: ปุ่มสร้าง --}}
    @if(Auth::user()->role == 'sale')
        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('approvals.create') }}" class="btn btn-success">
                {{ __('messages.newpaper') }}
            </a>
        </div>
    @endif

{{-- แถว 2: ตัวกรอง + เรียงวันที่ --}}
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <form action="{{ route('approvals.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-wrap">
        <select name="sales_user_id" class="form-select form-select-sm" style="width:160px" onchange="this.form.submit()">
            <option value="">{{ __('messages.sales_user_id') }}</option>
            @foreach($salesList as $id => $name)
                <option value="{{ $id }}" {{ request('sales_user_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>

        <select name="status" class="form-select form-select-sm" style="width:180px" onchange="this.form.submit()">
            <option value="">{{ __('messages.sales_user_id') }}</option>
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
            $toggleText = $currentSort === 'newest' ? __('messages.sortN') : __('messages.sortO');
        @endphp
        <a href="{{ route('approvals.index', ['sort' => $toggleSort, 'sales_user_id' => request('sales_user_id'), 'status' => request('status')]) }}" class="btn btn-sm btn-outline-primary">
            {{ $toggleText }}
        </a>
    </div>
</div>

{{-- แถว 3: ตารางหลัก --}}
<div class="table-responsive">
    <table class="table table-bordered table-sm align-middle">
        <thead class="text-center bg-light">
            <tr>
                <th>#</th>
                <th>GroupID</th>
                <th>{{ __('messages.car_model') }}</th>
                <th>{{ __('messages.sales_name') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.updated_at') }}</th>
                <th>{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @forelse($mainApprovals as $approval)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $approval->group_id }}</td>
                <td>{{ $approval->car_model }}</td> 
                <td>{{ $approval->sales_name }}</td>
                <td class="text-center">
                    {{-- แสดงสถานะตามจริง --}}
                    @if($approval->status == 'Pending_Admin')
                        <span class="badge px-3 py-2" style="background-color: #fd178a; color: white;">{{ __('messages.statusPA') }}</span>
                    @elseif($approval->status == 'Pending_Manager')
                        <span class="badge px-3 py-2" style="background-color: #ff6716; color: white;">{{ __('messages.statusPM') }}</span>
                    @elseif($approval->status == 'Approved')
                        <span class="badge px-3 py-2" style="background-color: #03b11a; color: white;">{{ __('messages.statusA') }}</span>
                    @elseif($approval->status == 'Reject')
                        <span class="badge px-3 py-2" style="background-color: #fe1c1c; color: white;">{{ __('messages.statusR') }}</span>
                    @endif
                </td>
                <td class="text-center text-muted small">{{ $approval->updated_at }}</td>
                <td class="text-center">
                    @php $role = strtolower($user->role); @endphp
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
            <tr><td colspan="7" class="text-center text-muted p-4">{{ __('messages.notitext') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- ตาราง Draft (แสดงเฉพาะ Sale) --}}
@if($isSale && $draftApprovals->count())
    <hr class="my-5">
    <h6 class="fw-bold mb-3 text-secondary"><i class="bi bi-file-earmark-text"></i> {{ __('messages.draftW') }}</h6>
    <div class="table-responsive">
        <table class="table table-sm table-hover align-middle border">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>GroupID</th>
                    <th>{{ __('messages.car_model') }}</th>
                    <th>{{ __('messages.sales_name') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($draftApprovals as $approval)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $approval->group_id }}</td>
                    <td>{{ $approval->car_model }}</td>
                    <td>{{ $approval->sales_name }}</td>
                    <td class="text-center">
                        {{-- Sale จะเห็นงานที่ Reject เป็น Draft --}}
                        @if($approval->status == 'Reject')
                            <span class="badge bg-warning text-dark px-3 py-2">{{ __('messages.statusd') }}</span>
                        @else
                            <span class="badge bg-light text-dark border px-3 py-2">{{ __('messages.statusd') }}</span>
                        @endif
                    </td>
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