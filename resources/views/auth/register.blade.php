@extends('layout_auth')

@section('title', 'สมัครสมาชิก (Sales)')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">ชื่อ-นามสกุล</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">อีเมล</label>
            <input type="text" id="reg_email" name="email" class="form-control"
                   required value="{{ old('email') }}">
            <div class="form-text">กรุณาใช้อีเมล @ypb.co.th"</div>
        </div>

        <div class="mb-3">
            <label class="form-label">รหัสผ่าน</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">ยืนยันรหัสผ่าน</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-success w-100">สมัครสมาชิก</button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}">มีบัญชีแล้ว? เข้าสู่ระบบ</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-3 mb-0">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>

    <script>
        function normalizeEmail(inputId){
            const inp = document.getElementById(inputId);
            if(!inp) return;
            let v = inp.value.trim();
            if(v && !v.includes('@')){
                inp.value = v + '@ypb.co.th';
            }
        }
        document.getElementById('reg_email')?.addEventListener('blur', () => normalizeEmail('reg_email'));
        document.querySelector('form').addEventListener('submit', () => normalizeEmail('reg_email'));
    </script>
@endsection
