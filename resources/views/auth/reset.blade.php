@extends('layout_auth')

@section('title', 'รีเซ็ตรหัสผ่าน')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">อีเมล (@ypb.co.th)</label>
            <input type="email" id="reset_email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">รหัสผ่านใหม่</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">บันทึกรหัสผ่านใหม่</button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}">กลับไปหน้าเข้าสู่ระบบ</a>
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
        document.getElementById('reset_email')?.addEventListener('blur', () => normalizeEmail('reset_email'));
        document.querySelector('form').addEventListener('submit', () => normalizeEmail('reset_email'));
    </script>
@endsection
