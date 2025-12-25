<div class="d-flex gap-1">
    <a href="{{ route('approvals.show', $row->group_id) }}" class="btn btn-primary btn-sm">
        รายละเอียด
    </a>

    <a href="{{ route('approvals.edit', $row->group_id) }}" class="btn btn-warning btn-sm">
        แก้ไข
    </a>

    <form action="{{ route('approvals.destroy', $row->group_id) }}" method="POST"
          onsubmit="return confirm('ยืนยันลบใบอนุมัติชุดนี้?');">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm">ลบ</button>
    </form>
</div>
    @if($item->status == 'Draft' || $item->status == 'Reject')
        <a href="{{ route('approvals.edit', $item->id) }}" class="btn btn-warning btn-sm">
            {{ $item->status == 'Reject' ? 'แก้ไขงานที่ถูกตีกลับ' : 'แก้ไข Draft' }}
        </a>
    @endif