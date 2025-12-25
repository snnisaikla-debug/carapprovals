<a href="{{ route('approvals.show', $row->group_id) }}"
   class="btn btn-sm btn-primary">
    รายละเอียด
</a>

@if($item->status == 'Pending_Manager')
    <form action="{{ route('approvals.updateStatus', $item->id) }}" method="POST" style="display:inline;">
        @csrf
        <button name="action" value="approve" class="btn btn-success btn-sm">อนุมัติ (Approved)</button>
        <button name="action" value="reject" class="btn btn-danger btn-sm">Reject (ตีกลับ Sale)</button>
    </form>
@endif
