@extends('layout')

@section('title', 'My Profile')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3" style="font-size:16px;">
        {{-- ใช้คำสั่ง route('approvals.index') เพื่อระบุปลายทางให้แน่นอน --}}
        <a href="{{ route('approvals.index') }}" class="btn btn-secondary">
            ← ย้อนกลับ
        </a>
    </div>

        <div class="d-flex align-items-center gap-3" style="font-size:16px;">
            {{-- content เดิม --}}
        </div>
    </div>

        {{-- ✅ การ์ด: ข้อมูลบัญชี (About) --}}
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong>About</strong>
            </div>
            <div class="card-body">

                <form method="POST" action="{{ route('account.updateProfile') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">ชื่อ-สกุล</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', auth()->user()->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">อีเมล</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', auth()->user()->email) }}" required>
                            <small class="text-muted">แนะนำใช้ @ypb.co.th</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->role }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Joined</label>
                            <input type="text" class="form-control"
                                value="{{ auth()->user()->created_at?->format('Y-m-d H:i') }}" disabled>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-danger px-4">บันทึกข้อมูล</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- ✅ การ์ด: เปลี่ยนรูปโปรไฟล์ --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <strong>Profile Photo</strong>
            </div>
            <div class="card-body">

                <div class="d-flex align-items-center gap-3 mb-3">
                    <img
                        src="{{ auth()->user()->photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}"
                        alt="profile"
                        style="width:64px;height:64px;border-radius:50%;object-fit:cover;"
                    >
                    <div>
                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                        <div class="text-muted small">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('account.photo') }}" enctype="multipart/form-data">
                    @csrf
                    <label class="form-label">อัปโหลดรูป (JPG/PNG)</label>
                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                    <div class="mt-3">
                        <button class="btn btn-outline-danger">อัปโหลดรูป</button>
                    </div>
                </form>

                <small class="text-muted d-block mt-2">
                    * ถ้าจะทำ “crop” จริง เดี๋ยวเราค่อยเพิ่มด้วย Cropper.js ทีหลังได้ (ตอนนี้อัปโหลดก่อน)
                </small>

            </div>
        </div>

        {{-- ✅ การ์ด: เปลี่ยนรหัสผ่าน --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <strong>Password</strong>
            </div>
            <div class="card-body">

                <form method="POST" action="{{ route('account.updatePassword') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">รหัสผ่านเดิม</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">รหัสผ่านใหม่</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-danger px-4">เปลี่ยนรหัสผ่าน</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- ✅ การ์ด: ลบบัญชี (Soft delete) --}}
            {{-- ส่วนล่างของไฟล์ edit.blade.php --}}
            <hr class="my-5">

            <div class="card border-danger shadow-sm mb-5">
                <div class="card-header bg-transparent border-danger ">
                    <h5 class="text-danger mb-0">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">หากลบบัญชี ข้อมูลของคุณจะถูกระงับการใช้งานชั่วคราว (Soft Delete)</p>
                    
                    <form method="POST" action="{{ route('account.destroy') }}" onsubmit="return confirm('ยืนยันลบบัญชี? ระบบจะทำการ Logout ทันที');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">ลบบัญชี</button>
                    </form>
                </div>
            </div>
    </div>
</div>
@endsection
