<a href="{{ route('approvals.show', $row->group_id) }}"
   class="btn btn-sm btn-primary">
    รายละเอียด
</a>

 <a href="{{ route('approvals.edit', $row->group_id) }}" 
 class="btn btn-sm btn-warning">แก้ไข</a>

<form action="{{ route('approvals.destroy', $row->group_id) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirm('ยืนยันลบใบอนุมัติชุดนี้?')">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger">ลบ</button>
</form>
