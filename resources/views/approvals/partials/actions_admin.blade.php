<div class="d-flex gap-1 justify-content-center">
    <a href="{{ route('approvals.show', $approval->group_id) }}"
        class="btn btn-sm btn-secondary" style="opacity: 0.6;">
        {{ __('messages.details') }}
    </a>

    @if($approval->status == 'Pending_Admin')
        <form action="{{ route('approvals.updateStatus', $approval->group_id) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="status" value="Approved">
            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('ยืนยันอนุมัติ?')">{{ __('messages.statusA') }}</button>
        </form>

        <form action="{{ route('approvals.updateStatus', $approval->group_id) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="status" value="Reject">
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันตีกลับ?')">{{ __('messages.statusR') }}</button>
        </form>
        </form>
    @endif
</div> 