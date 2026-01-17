@extends('layout')

@section ('title', 'รายละเอียดใบอนุมัติ')

@section('content')

    <div class="d-flex justify-content-between mb-3">
        <button type="button" onclick="history.back()" class="btn btn-secondary">
            ← ย้อนกลับ
        </button>
    </div>

    <style>
        /* CSS สำหรับตารางและปุ่ม */
        .clickable-row { cursor: pointer; transition: background 0.2s; }
        .clickable-row:hover { background-color: #f0f7ff !important; }
        .active-version { background-color: #e7f1ff !important; border-left: 5px solid #0d6efd; }
        
        .fab-download {
            position: fixed; bottom: 20px; right: 20px;
            background-color: #b91c1c; color: white;
            border-radius: 50px; padding: 12px 20px;
            font-size: 16px; font-weight: bold;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 999;
        }
    </style>

{{-- -------------------------------------------------------- --}}
    {{-- ตารางประวัติ --}}
    <div class="card mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">ประวัติการแก้ไข (Group: {{ $current->group_id }})</h5>
            <small class="text-muted text-primary">คลิกที่แถวเพื่อดูข้อมูลในเวอร์ชันนั้นๆ</small>
        </div>
        <div class="table-responsive">
            <table class="table table-hover border mb-0" id="historyTable">
                <thead class="table-light text-center">
                    <tr>
                        <th>Version</th>
                        <th>สถานะ</th>
                        <th>ผู้สร้าง</th>
                        <th>วันที่สร้าง</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $row)
                    <tr class="clickable-row {{ $row->id == $current->id ? 'table-primary' : '' }}" 
                        data-id="{{ $row->id }}"
                        data-version="{{ $row->version }}">
                        <td class="text-center"><strong>V.{{ $row->version }}</strong></td>
                        <td class="text-center">
                            @php
                                $badgeColor = '#6c757d';
                                if ($row->status == 'Approved') $badgeColor = '#03b11a';
                                elseif ($row->status == 'Reject') $badgeColor = '#fe1c1c';
                                elseif ($row->status == 'Pending_Admin') $badgeColor = '#fd178a';
                                elseif ($row->status == 'Pending_Manager') $badgeColor = '#ff6716';
                            @endphp
                            <span class="badge" style="background-color: {{ $badgeColor }}; color: white; padding: 8px 12px;">
                                {{ $row->status }}
                            </span>
                        </td>
                        <td>{{ $row->sales_name }}</td>
                        <td class="text-center">{{ $row->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- พื้นที่แสดงรายละเอียด (โหลด V. ล่าสุดรอไว้) --}}
    <div id="version-detail-display">
        @include('approvals.partials.preview', ['approval' => $current])
    </div>
    
    {{-- ปุ่ม Floating PDF --}}
    <a href="{{ route('approvals.exportPdf', $current->id) }}"
        id="pdfBtn"
        class="fab-download  text-decoration-none">
            Export PDF
    </a>

    {{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.clickable-row').click(function() {
        let versionId = $(this).data('id');
        let versionNum = $(this).data('version');

        // 1. Highlight แถวที่เลือก
        $('.clickable-row').removeClass('table-primary');
        $(this).addClass('table-primary');

        // 2. โหลดเนื้อหาพรีวิว (Partial View)
        let url = "{{ url('/approvals/fetch-version') }}/" + versionId;
        $.get(url, function(data) {
            $('#version-detail-display').html(data);
        });

        // 3. เปลี่ยนลิงก์ปุ่ม PDF ให้เป็น ID ของเวอร์ชันที่คลิก
        let pdfUrl = "{{ url('/approvals') }}/" + versionId + "/pdf";
        $('#pdfBtn').attr('href', pdfUrl);
    });
});
</script>
@endsection