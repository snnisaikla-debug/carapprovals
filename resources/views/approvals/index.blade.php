@extends('layout')

@section('title', 'รายการใบอนุมัติ')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('approvals.create') }}" class="btn btn-success">
            + สร้างใบอนุมัติใหม่
        </a>

    <div class="d-flex align-items-center gap-3">
    
@php
    $currentSort = request('sort', 'newest');
    $nextSort = $currentSort === 'newest' ? 'oldest' : 'newest';
@endphp

    {{-- ปุ่มเรียงวันที่ --}}
          <div>
            เรียงวันที่:
                <a href="{{ route('approvals.index', [
                    'sort' => request('sort') === 'newest' ? 'oldest' : 'newest',  // ถ้าอยากให้ปุ่มเดียวสลับ
                    'sales' => request('sales'),
                    'status' => request('status'),
                ]) }}" class="btn btn-sm btn-outline-primary">
                    เรียงวันที่: {{ request('sort','newest') === 'newest' ? 'ล่าสุด' : 'เก่าสุด' }}
                </a>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-sm">
        <thead class="text-center">
            <tr>
                <th>#</th>
                <th>GroupID</th>
                <th>รุ่นรถ</th>
                <th>ชื่อผู้ส่งคำขอ</th>
                <th>สถานะ</th>
                <th>อัปเดตล่าสุด</th>
                <th></th> {{-- เปลี่ยนหัวคอลัมน์ --}}
            </tr>
            </thead>
<tbody>
    @foreach($approvals as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->group_id }}</td>
        <td>{{ $row->car_model }}</td>
        <td>{{ $row->sales_name }}</td> {{-- ชื่อ-สกุลจากบัญชี --}}
        <td>{{ $row->status }}</td>
        <td>{{ $row->updated_at }}</td>

        </form>
             {{-- เชื่อมไฟล์ partials --}}
        
        <td class="text-nowrap">
            @if(auth()->user()->role === 'sale')
                @include('approvals.partials.actions_sale', ['row' => $row])
            @elseif(auth()->user()->role === 'admin')
                @include('approvals.partials.actions_admin', ['row' => $row])
            @elseif(auth()->user()->role === 'head')
                @include('approvals.partials.actions_head', ['row' => $row])
            @endif
        </td>
            </tr>
    @endforeach
</tbody>
    </table>
@endsection
