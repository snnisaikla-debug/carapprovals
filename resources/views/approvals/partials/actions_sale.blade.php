<div class="d-flex gap-1">
    <a href="{{ route('approvals.show', $approval->group_id) }}" 
        class="btn btn-sm btn-secondary" style="opacity: 0.6;">
        รายละเอียด
    </a>

    @if(in_array($approval->status, ['Draft', 'Pending_Admin']))
    <a href="{{ route('approvals.edit', $approval->id) }}" class="btn btn-warning btn-sm" title="แก้ไข">
        <i class="bi bi-pencil"></i>แก้ไข
    </a>

    <form action="{{ route('approvals.destroy', $approval->group_id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบ?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" title="ลบ">
            <i class="bi bi-trash"></i>ลบ
        </button>
    </form>
    @endif
</div>