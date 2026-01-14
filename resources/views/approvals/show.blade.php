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
                    <tr class="clickable-row {{ $row->id == $current->id ? 'table-primary' : '' }}" data-id="{{ $row->id }}">
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
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            รายละเอียดข้อมูล <span id="ver-label">V.{{ $current->version }}</span>
        </div>
        <div class="card-body" id="version-detail-display">
            @include('approvals.partials.detail_table', ['approval' => $current])
        </div>
    </div>

    {{-- ปุ่ม Floating PDF --}}
    <a href="{{ route('approvals.exportPdf', $current->id) }}" class="fab-download text-decoration-none">
        Export PDF
    </a>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.clickable-row').click(function() {
            let versionId = $(this).data('id');
            let versionName = $(this).find('strong').text(); // ดึงคำว่า V.1, V.2 มาโชว์
            
            // 1. ไฮไลท์แถว
            $('.clickable-row').removeClass('table-primary');
            $(this).addClass('table-primary');

            // 2. อัปเดตหัวข้อรายละเอียด
            $('#ver-label').text(versionName);

            // 3. ใช้ Ajax ดึงข้อมูล
            $.get('/approvals/fetch-version/' + versionId, function(data) {
                $('#version-detail-display').html(data);
            }).fail(function() {
                alert('ไม่พบข้อมูลเวอร์ชันนี้');
            });
        });
    });
    </script>
@endsection