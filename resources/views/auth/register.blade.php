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
            <div class="position-relative"> <input type="password" 
                        id="password" 
                        name="password"
                        class="form-control pe-5" required>
                <button type="button"
                        class="btn position-absolute end-0 top-50 translate-middle-y me-2 p-0"
                        onclick="togglePassword('password', this)"
                        style="border:none; background:transparent; line-height: 1; display: flex; align-items: center; height: 100%;">
                    <i class="bi bi-eye fs-5"></i>
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">ยืนยันรหัสผ่าน</label>
            <div class="position-relative"> <input type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-control pe-5" required>
                <button type="button"
                        class="btn position-absolute end-0 top-50 translate-middle-y me-2 p-0"
                        onclick="togglePassword('password_confirmation', this)"
                        style="border:none; background:transparent; line-height: 1; display: flex; align-items: center; height: 100%;">
                    <i class="bi bi-eye fs-5"></i>
                </button>
            </div>
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
    
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
    
@endsection
