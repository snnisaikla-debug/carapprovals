<div class="d-flex gap-1 justify-content-center">
    <a href="{{ route('approvals.show', $approval->group_id) }}"
        class="btn btn-sm btn-secondary" style="opacity: 0.6;">
        รายละเอียด
    </a>

    @if($approval->status == 'Pending_Manager')
        <form action="{{ route('approvals.updateStatus', $approval->group_id) }}" method="POST" class="d-inline">
            @csrf
            {{-- Manager อนุมัติแล้วให้ส่งต่อ Admin หรือจบงาน (แล้วแต่ Flow) --}}
            {{-- สมมติว่า Manager อนุมัติแล้วต้องส่งให้ Admin ต่อ ให้แก้ value="Pending_Admin" --}}
            {{-- แต่ถ้า Manager ใหญ่สุด ให้ใช้ value="Approved" --}}
            <input type="hidden" name="status" value="Approved"> 
            
            <button type="submit" class="btn btn-success btn-sm" title="อนุมัติ" onclick="return confirm('ยืนยันการอนุมัติ?');">
                <i class="bi bi-check-circle"></i> อนุมัติ
            </button>
        </form>

        <form action="{{ route('approvals.updateStatus', $approval->group_id) }}" method="POST" class="d-inline">
            <input type="hidden" name="status" value="Reject">
            <button type="submit" class="btn btn-danger btn-sm" title="ไม่อนุมัติ" onclick="return confirm('ยืนยันการตีกลับ (Reject)?');">
                <i class="bi bi-x-circle"></i> ปฏิเสธ
            </button>
        </form>
    @endif
</div>