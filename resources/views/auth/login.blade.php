@extends('layout_auth')

@section('title', 'เข้าสู่ระบบ')

@section('content')
    @if (session('status'))
        <div class="alert alert-success py-2">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">อีเมล</label>
            <input type="text" id="login_email" name="email" class="form-control"
                   required value="{{ old('email') }}">
            <div class="form-text">ไม่ต้องเติม @ ก็ได้</div>
        </div>

        <div class="mb-3">
            <label class="form-label">รหัสผ่าน</label>
            <div class="position-relative"> <input type="password" 
                        id="login_password" 
                        name="password"
                        class="form-control pe-5" 
                        required>
                
                <button type="button"
                        class="btn position-absolute end-0 top-50 translate-middle-y me-2 p-0"
                        onclick="togglePassword('login_password', this)"
                        style="border:none; background:transparent; display: flex; align-items: center; height: 100%;">
                    <i class="bi bi-eye fs-5"></i>
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    จำรหัสผ่าน
                </label>
            </div>
            <a href="{{ route('password.request') }}" class="small">รีเซ็ตรหัสผ่าน</a>
        </div>

        <button class="btn btn-primary w-100">เข้าสู่ระบบ</button>

        <div class="text-center mt-3">
            <a href="{{ route('register') }}">ยังไม่มีบัญชี? สมัครสมาชิก</a>
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
        document.getElementById('login_email')?.addEventListener('blur', () => normalizeEmail('login_email'));
        document.querySelector('form').addEventListener('submit', () => normalizeEmail('login_email'));
    
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                // เปลี่ยนไอคอนเป็นรูปตาที่มีขีดฆ่า
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                // เปลี่ยนไอคอนกลับเป็นรูปตาปกติ
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
@endsection
