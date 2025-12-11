@extends('layout')

@section('title', 'รายการใบอนุมัติ')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('approvals.create') }}" class="btn btn-success">
            + สร้างใบอนุมัติใหม่ (Sales)
        </a>

        <div class="d-flex align-items-center gap-3">
    
    {{-- Dropdown เลือก Sales --}}
    <form action="{{ route('approvals.index') }}" method="GET" class="d-flex align-items-center">
        <label class="me-2">ดูเฉพาะ Sales:</label>
        <select name="sales" class="form-select form-select-sm me-2" onchange="this.form.submit()">
            <option value="">-- ทั้งหมด --</option>
            @foreach ($salesList as $sales)
                <option value="{{ $sales }}"
                        {{ request('sales') == $sales ? 'selected' : '' }}>
                    {{ $sales }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- ปุ่มเรียงวันที่ --}}
            <div>
        เรียงวันที่:
        <a href="{{ route('approvals.index', ['sort' => 'newest', 'sales' => request('sales')]) }}"
           class="btn btn-sm {{ request('sort') === 'newest' ? 'btn-primary' : 'btn-outline-primary' }}">
            ล่าสุดก่อน
        </a>

        <a href="{{ route('approvals.index', ['sort' => 'oldest', 'sales' => request('sales')]) }}"
           class="btn btn-sm {{ request('sort') === 'oldest' ? 'btn-primary' : 'btn-outline-primary' }}">
            เก่าสุดก่อน
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
                <th>ชื่อลูกค้า</th>
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
        <td>{{ $row->customer_name }}</td>
        <td>{{ $row->sales_name }}</td> {{-- ชื่อ-สกุลจากบัญชี --}}
        <td>{{ $row->status }}</td>
        <td>{{ $row->updated_at }}</td>
        <td>
            <a href="{{ route('approvals.show', $row->group_id) }}"
               class="btn btn-primary btn-sm mb-1">
                เปิดดู/ประวัติ
            </a>

            {{-- ปุ่มแก้ไข (ให้ Admin/Head ใช้ หรือจะเปิดให้ Sales ก็ได้) --}}
            @if(auth()->user()->role === 'ADMIN' || auth()->user()->role === 'HEAD')
                <a href="{{ route('approvals.edit', $row->group_id) }}"
                   class="btn btn-warning btn-sm mb-1">
                    แก้ไข
                </a>

                <form action="{{ route('approvals.destroy', $row->group_id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('ยืนยันลบใบอนุมัติ Group {{ $row->group_id }} ?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm mb-1">
                        ลบ
                    </button>
                </form>
            @endif
        </td>
    </tr>
@endforeach
</tbody>
    </table>
@endsection
