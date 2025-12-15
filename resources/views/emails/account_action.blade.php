<p>สวัสดี {{ $action->user->name }}</p>

@if($action->type === 'change_email')
    <p>คุณได้ขอเปลี่ยนอีเมลใหม่เป็น: <b>{{ $action->payload['new_email'] }}</b></p>
@elseif($action->type === 'change_password')
    <p>คุณได้ขอเปลี่ยนรหัสผ่านใหม่</p>
@endif

<p>กรุณากดยืนยันภายในเวลาที่กำหนด:</p>

<p>
    <a href="{{ route('account.confirm', $action->token) }}">
        ✅ คลิกเพื่อยืนยัน
    </a>
</p>

<p>หากคุณไม่ได้เป็นผู้ทำรายการนี้ สามารถละเว้นอีเมลนี้ได้</p>
