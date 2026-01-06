<a href="{{ route('approvals.show', $approval->group_id) }}"
    class="btn btn-sm btn-secondary" style="opacity: 0.6;">
    รายละเอียด
</a>

@if($approval->status == 'Pending_Manager')
    <form action="{{ route('approvals.updateStatus', $row->id) }}" method="POST" style="display:inline;">
        @csrf
        <button name="action" value="approve" class="btn btn-success btn-sm">อนุมัติ</button>
        <button name="action" value="reject" class="btn btn-danger btn-sm">ไม่อนุมัติ</button>
    </form>
@endif