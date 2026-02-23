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

    /* 1. คอนเทนเนอร์หลัก (ยึดตำแหน่งเดิมของคุณ) */
    .fab-container {
        position: fixed;
        bottom: 30px;  /* ระยะห่างจากด้านล่าง */
        right: 30px;   /* ระยะห่างจากด้านขวา */
        z-index: 1000;
        display: flex;
        flex-direction: column-reverse; /* ให้เมนูเรียงขึ้นด้านบน */
        align-items: end; /* ชิดขวา */
        gap: 15px; /* ระยะห่างระหว่างปุ่ม */
    }

    /* 2. ปุ่มหลัก (ตัวแม่) */
    .fab-main {
        background-color: #f1d411; /* สีน้ำเงิน (แก้ตามธีมได้) */
        color: black;
        border: none;
        border-radius: 50px; /* ทำเป็นวงรี */
        padding: 15px 25px;
        font-size: 16px;
        font-weight: bold;
        box-shadow: 0 4px 10px rgb(248, 168, 10);
        cursor: pointer;
        transition: transform 0.3s, background-color 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .fab-main:hover {
        transform: scale(1.05);
        background-color: #fffa77;
    }

    /* เมื่อปุ่มถูกเปิด (หมุนไอคอน) */
    .fab-main.active i {
        transform: rotate(90deg);
    }
    .fab-main.active {
        background-color: #ffffff; /* เปลี่ยนสีเมื่อกดเปิด */
    }

    /* 3. กล่องเก็บปุ่มย่อย (Excel, PDF) */
    .fab-options {
        display: flex;
        flex-direction: column; /* เรียงแนวตั้ง */
        gap: 10px;
        opacity: 0; /* ซ่อนก่อน */
        pointer-events: none; /* ห้ามกดตอนซ่อน */
        transform: translateY(20px); /* ดันลงไปข้างล่างนิดนึง */
        transition: all 0.3s ease-in-out;
    }

    /* สถานะเมื่อเปิดเมนู (ไหลขึ้นมา) */
    .fab-options.show {
        opacity: 1;
        pointer-events: auto; /* กดได้แล้ว */
        transform: translateY(0); /* เด้งกลับมาที่เดิม */
    }

    /* 4. ดีไซน์ปุ่มย่อย */
    .fab-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        color: white;
        text-decoration: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        position: relative;
        transition: transform 0.2s;
    }

    .fab-btn:hover {
        transform: scale(1.1);
        color: white;
    }

    /* สีเฉพาะของแต่ละปุ่ม */
    .fab-excel { background-color: #198754; } /* สีเขียว */
    .fab-pdf   { background-color: #dc3545; } /* สีแดง */

    /* 5. ป้ายข้อความ (Tooltip) ด้านข้างปุ่มย่อย */
    .fab-label {
        position: absolute;
        right: 60px; /* อยู่ซ้ายมือของปุ่ม */
        background-color: rgba(0,0,0,0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }

    /* โชว์ป้ายชื่อเมื่อเอาเมาส์ชี้ */
    .fab-btn:hover .fab-label {
        opacity: 1;
    }
    /* สีปุ่มเดิม */
    .fab-excel { background-color: #198754; } /* Excel Green */
    .fab-pdf   { background-color: #dc3545; } /* PDF Red */

    /* เพิ่ม: สีปุ่ม Google Sheets (เขียวเข้มแบบ Google) */
    .fab-sheets { background-color: #0F9D58; } 

    /* ปรับไอคอนให้ดูสมดุล */
    .fab-sheets i { font-size: 20px; }
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
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.sales_name') }}</th>
                        <th>{{ __('messages.remark') }}</th>
                        <th>{{ __('messages.updated_at') }}</th>
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
                                elseif ($row->status == 'Waiting') $badgeColor = '#0580a2';
                            @endphp
                            <span class="badge" style="background-color: {{ $badgeColor }}; color: white; padding: 8px 12px;">
                                {{ $row->status }}
                            </span>
                        </td>
                        <td class="text-center">{{ $row->sales_name }}</td>
                        <td class="text-center danger small">{{ $row->remark ?? '-' }}</td>
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
    <div class="fab-container">
        <button class="fab-main" id="fabMainBtn" onclick="toggleFab()">
            <i class="fas fa-bars" id="fabIcon"></i>
            <span>Export</span>
        </button>

    <div class="fab-options" id="fabOptions">
       <a href="{{ route('approvals.exportCsv') }}" class="fab-btn fab-sheets" title="Google Sheets (CSV)">
            <i class="fas fa-file-csv"></i> 
            <span>CSV</span>
        </a>

        <a href="{{ route('approvals.exportExcel') }}" class="fab-btn fab-excel" title="Export Excel">
            <i class="fas fa-file-excel"></i> 
            <span>Excel</span>
        </a>

        <a href="{{ route('approvals.exportPdf', $current->id) }}" class="fab-btn fab-pdf" title="Export PDF" target="_blank">
            <i class="fas fa-file-pdf"></i>
            <span>PDF</span>
        </a>
    </div>
</div>

    {{-- Scripts Export file --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    
    $('.clickable-row').click(function() {
        
        // เช็คว่ากดติดไหม (ดูใน Console F12)
        console.log("Clicked row:", $(this).data('id'));

        let versionId = $(this).data('id');

        // 1. เปลี่ยนสีแถวเพื่อบอกว่าเลือกอันนี้อยู่
        $('.clickable-row').removeClass('table-primary');
        $(this).addClass('table-primary');

        // 2. โหลดเนื้อหาพรีวิวผ่าน AJAX
        // ตรวจสอบ URL ให้แน่ใจว่าไม่มี / ซ้อนกัน
        let url = "{{ url('/approvals/fetch-version') }}/" + versionId;
        
        $('#version-detail-display').html('<div class="text-center p-4"><div class="spinner-border text-primary"></div><p>กำลังโหลดข้อมูล...</p></div>');

        $.get(url, function(data) {
            $('#version-detail-display').html(data);
        }).fail(function() {
            $('#version-detail-display').html('<div class="alert alert-danger">โหลดข้อมูลไม่สำเร็จ กรุณาลองใหม่</div>');
        });

        // 3. เปลี่ยนปุ่ม PDF ให้เป็นของเวอร์ชันนั้น
        let pdfUrl = "{{ url('/approvals') }}/" + versionId + "/pdf";
        $('#pdfBtn').attr('href', pdfUrl);
    });
});
</script>
<script>
    function toggleFab() {
        const fabOptions = document.getElementById('fabOptions');
        const fabMainBtn = document.getElementById('fabMainBtn');
        const fabIcon = document.getElementById('fabIcon');

        // สลับคลาส show เพื่อแสดง/ซ่อน เมนูย่อย
        fabOptions.classList.toggle('show');
        
        // สลับคลาส active เพื่อหมุนไอคอนปุ่มหลัก
        fabMainBtn.classList.toggle('active');

        // เปลี่ยนไอคอน (ถ้าชอบ) จาก 3 ขีด เป็น กากบาท
        if (fabMainBtn.classList.contains('active')) {
            fabIcon.classList.remove('fa-bars');
            fabIcon.classList.add('fa-times');
        } else {
            fabIcon.classList.remove('fa-times');
            fabIcon.classList.add('fa-bars');
        }
    }

    // (Option) คลิกที่อื่นเพื่อปิดเมนู
    document.addEventListener('click', function(event) {
        const container = document.querySelector('.fab-container');
        const fabOptions = document.getElementById('fabOptions');
        const fabMainBtn = document.getElementById('fabMainBtn');
        const fabIcon = document.getElementById('fabIcon');

        if (!container.contains(event.target)) {
            fabOptions.classList.remove('show');
            fabMainBtn.classList.remove('active');
            fabIcon.classList.remove('fa-times');
            fabIcon.classList.add('fa-bars');
        }
    });
</script>
@endsection