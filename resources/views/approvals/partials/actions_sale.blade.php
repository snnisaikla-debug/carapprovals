<div class="d-flex gap-1">
    <a href="{{ route('approvals.show', $approval->group_id) }}" 
        class="btn btn-sm btn-secondary" style="opacity: 0.6;">
        รายละเอียด
    </a>

    <a href="{{ route('approvals.edit', $approval->group_id) }}" class="btn btn-warning btn-sm">
        แก้ไข
    </a>

    <form action="{{ route('approvals.destroy', $approval->group_id) }}" method="POST"
          onsubmit="return confirm('ยืนยันลบใบอนุมัติชุดนี้?');">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm">ลบ</button>
    </form>
</div>