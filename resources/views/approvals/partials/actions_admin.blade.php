<div class="d-flex gap-1 justify-content-center">
    <a href="{{ route('approvals.show', $approval->group_id) }}"
        class="btn btn-sm btn-secondary" style="opacity: 0.6;">
        {{ __('messages.details') }}
    </a>

    @if($approval->status == 'Waiting')
        
        {{-- ปุ่มตีกลับ (Reject) --}}
        <form action="{{ route('approvals.updateStatus', $approval->group_id) }}" method="POST" class="d-inline" 
            onsubmit="let r = prompt('ระบุเหตุผลที่ตีกลับ (ถ้ามี):'); if(r === null) return false; this.remark.value = r; return true;">
            @csrf
            <input type="hidden" name="status" value="Reject">
            <input type="hidden" name="remark" value=""> {{-- Input ซ่อนไว้รอรับค่าจาก Prompt --}}
            
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="bi bi-x-circle"></i> {{ __('messages.statusR') }}
            </button>
        </form>

        {{-- ปุ่มอนุมัติ (Approve) --ทำแบบเดียวกันถ้าอยากให้ใส่หมายเหตุตอนอนุมัติ--}}
        <form action="{{ route('approvals.updateStatus', $approval->group_id) }}" method="POST" class="d-inline"
            onsubmit="let r = prompt('ระบุหมายเหตุการอนุมัติ (ถ้ามี):'); if(r === null) return false; this.remark.value = r; return true;">
            @csrf
            <input type="hidden" name="status" value="Approved">
            <input type="hidden" name="remark" value="">
            
            <button type="submit" class="btn btn-success btn-sm">
                <i class="bi bi-check-circle"></i> {{ __('messages.statusA') }}
            </button>
        </form>

        <a href="{{ route('approvals.edit', $approval->id) }}" class="btn btn-warning btn-sm" title="แก้ไข">
            <i class="bi bi-pencil"></i> {{ __('messages.edit') }}
        </a>

    @elseif($approval->status == 'Approved')

        <form action="{{ route('approvals.updateStatus', $approval->group_id) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="status" value="Reject">

            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('⚠️ ยืนยันยกเลิกการอนุมัติ?\nเอกสารจะถูกตีกลับไปให้เซลล์แก้ไข')">
                <i class="bi bi-arrow-counterclockwise"></i> ยกเลิกอนุมัติ
            </button>
        </form>
    @endif
</div>