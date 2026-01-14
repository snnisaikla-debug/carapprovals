@extends('layout')

@section ('title', 'รายละเอียดใบอนุมัติ ')

@section('content')

    <div class="d-flex justify-content-between mb-3">
        <button type="button" onclick="history.back()" class="btn btn-secondary">
            ← ย้อนกลับ
        </button>
    </div>

    <style>
    /* ทำให้แถวตารางดูเหมือนคลิกได้ */
    .clickable-row { cursor: pointer; transition: background 0.2s; }
    .clickable-row:hover { background-color: #f0f7ff !important; }
    .active-version { background-color: #e7f1ff !important; border-left: 5px solid #0d6efd; }
</style>

<div class="card mb-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">ประวัติการแก้ไข (Group: {{ $current->group_id }})</h5>
        <small class="text-muted text-primary">คลิกที่แถวเพื่อดูข้อมูลในเวอร์ชันนั้นๆ</small>
    </div>
    <div class="table-responsive">
        <table class="table table-hover border mb-0">
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
            {{-- เพิ่ม class clickable-row และ data-id เพื่อใช้ใน JavaScript --}}
                <tr class="clickable-row text-center {{ $row->id == $current->id ? 'table-primary' : '' }}" 
                    data-id="{{ $row->id }}" 
                    style="cursor: pointer;">
                    <td><strong>V.{{ $row->version }}</strong></td>
                    <td class="text-center">
                        @php
                            // 1. กำหนดสีตามสถานะไว้ในตัวแปรก่อน
                            $badgeColor = '#6c757d'; // สีเทาเริ่มต้น
                            if ($row->status == 'Approved') {
                                $badgeColor = '#03b11a';
                            } elseif ($row->status == 'Reject') {
                                $badgeColor = '#fe1c1c';
                            } elseif ($row->status == 'Pending_Admin') {
                                $badgeColor = '#fd178a';
                            } elseif ($row->status == 'Pending_Manager') {
                                $badgeColor = '#ff6716';
                            }
                        @endphp
                        {{-- 2. นำตัวแปรมาใช้งานใน style แบบเรียบง่าย --}}
                        <span class="badge" style="background-color: {{ $badgeColor }}; color: white; padding: 8px 12px;">
                            {{ $row->status }}
                        </span>
                    </td>
                    <td>{{ $row->sales_name }}</td>
                    <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- พื้นที่แสดงข้อมูลด้านล่าง (จะแสดง V. ล่าสุดรอไว้เลย) --}}
<div id="version-content-area" class="mt-4 p-3 border rounded bg-white shadow-sm">
    <h5 class="text-primary mb-3">รายละเอียดข้อมูลฉบับ <span id="v-label">V.{{ $current->version }}</span></h5>
    <div id="version-detail-target">
        @include('approvals.partials.detail_table', ['approval' => $current])
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
<script>
$(document).ready(function() {
    // เมื่อคลิกที่แถวตาราง
    $('.clickable-row').click(function() {
        let id = $(this).data('id');
        
        // ไฮไลท์แถวที่เลือก
        $('.clickable-row').removeClass('table-primary');
        $(this).addClass('table-primary');

        // โหลดข้อมูลเวอร์ชันนั้นมาแสดง
        $.get('/approvals/fetch-version/' + id, function(html) {
            $('#version-detail-target').html(html);
            // อัปเดตเลข V. บนหัวข้อ
            let versionText = $(this).find('td:first').text();
            $('#v-label').text(versionText);
        }.bind(this));
    });
});
</script>
@endsection

