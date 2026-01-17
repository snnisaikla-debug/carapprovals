@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3" style="font-size:16px;">
        {{-- ใช้คำสั่ง route('approvals.index') เพื่อระบุปลายทางให้แน่นอน --}}
        <a href="{{ route('approvals.index') }}" class="btn btn-secondary">
            ← ย้อนกลับ
        </a>
    </div>

    {{-- แจ้งเตือนสำเร็จ --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- แจ้งเตือนไม่สำเร็จ --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-warning">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if (session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif

            <div class="card border-danger mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-key"></i> เปลี่ยนรหัสผ่าน
                </div>
                <div class="card-body">
                    <form action="{{ route('account.password.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>รหัสผ่านปัจจุบัน</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="current_password" id="current_password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('current_password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3 row">
                            <label>รหัสผ่านใหม่</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                            <div class="mb-3 row">
                                <label>ยืนยันรหัสผ่านใหม่</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                        <button type="submit" class="btn btn-primary">ยืนยันเปลี่ยนรหัสผ่านใหม่</button>
                    </form>
                </div>
            </div>
            
            {{-- การ์ดเปลี่ยนอีเมล --}}
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-envelope"></i> เปลี่ยนอีเมล
                </div>
                <div class="card-body">
                    <div class="alert alert-info py-2">
                        <small>อีเมลปัจจุบัน: <strong>{{ Auth::user()->email }}</strong></small>
                    </div>

                    <form action="{{ route('account.email.request') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>อีเมลใหม่</label>
                            <input type="email" name="new_email" class="form-control @error('new_email') is-invalid @enderror" placeholder="example@ypb.co.th">
                            @error('new_email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label>ยืนยันด้วยรหัสผ่านปัจจุบัน</label>
                             <div class="input-group">
                                <input type="password" class="form-control" name="current_password_for_email" id="current_password_for_email" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password_for_email', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('current_password_for_email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- SCRIPT สำหรับกดสลับตา (Toggle Eye) --}}
<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash'); // เปลี่ยนเป็นรูปตาขีดฆ่า
    } else {
        input.type = "password";
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye'); // เปลี่ยนกลับเป็นรูปตาปกติ
    }
}
</script>
@endsection