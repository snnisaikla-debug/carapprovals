<a href="{{ route('approvals.show', $row->group_id) }}"
   class="btn btn-sm btn-primary">
    รายละเอียด
</a>

@if($row->status === 'WAIT_HEAD')
    <form action="{{ route('approvals.approve', $row->group_id) }}"
          method="POST"
          class="d-inline">
        @csrf
        <button class="btn btn-sm btn-success">Approve</button>
    </form>

    <form action="{{ route('approvals.reject', $row->group_id) }}"
          method="POST"
          class="d-inline">
        @csrf
        <button class="btn btn-sm btn-danger">Reject</button>
    </form>
@endif
