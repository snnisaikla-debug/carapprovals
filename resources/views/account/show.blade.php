@extends('layout')

@section('title', 'บัญชีของฉัน')

@section('content')
    <h4 class="mb-3">บัญชีของฉัน</h4>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">โปรไฟล์</div>
                <div class="card-body">
                    @if (session('status_profile'))
                        <div class="alert alert-success">{{ session('status_profile') }}</div>
                    @endif

                    <form method="POST" action="{{ route('account.updateProfile') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 text-center">
                            @if($user->avatar)
                                <img src="{{ asset('storage/'.$user->avatar) }}" alt="Avatar"
                                     class="rounded-circle mb-2" style="width:80px;height:80px;object-fit:cover;">
                            @else
                                <div class="rounded-circle bg-secondary text-white d-inline-flex
                                            justify-content-center align-items-center mb-2"
                                     style="width:80px;height:80px;">
                                    {{ mb_substr($user->name,0,1) }}
                                </div>
                            @endif
                            <div>
                                <input type="file" name="avatar" class="form-control mt-2">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ชื่อ-นามสกุล</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">อีเมล</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            <small class="text-muted">
                                (การเปลี่ยนอีเมล + ยืนยันผ่านเมล จะทำในขั้นตอนต่อไป)
                            </small>
                        </div>

                        <button class="btn btn-primary">บันทึกโปรไฟล์</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card mb-4">
                <div class="card-header">เปลี่ยนรหัสผ่าน</div>
                <div class="card-body">
                    @if (session('status_password'))
                        <div class="alert alert-success">{{ session('status_password') }}</div>
                    @endif

                    <form method="POST" action="{{ route('account.updatePassword') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">รหัสผ่านเดิม</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">รหัสผ่านใหม่</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button class="btn btn-warning">เปลี่ยนรหัสผ่าน</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-danger">ลบบัญชี</div>
                <div class="card-body">
                    <p class="text-muted small mb-2">
                        การลบบัญชีจะทำให้ไม่สามารถเข้าสู่ระบบด้วยบัญชีนี้ได้อีก
                    </p>
                    <form method="POST" action="{{ route('account.destroy') }}"
                          onsubmit="return confirm('ยืนยันลบบัญชีนี้จริงหรือไม่?');">
                        @csrf
                        @method('DELETE')
                        <div class="mb-2">
                            <label class="form-label">พิมพ์คำว่า DELETE เพื่อยืนยัน</label>
                            <input type="text" name="confirm" class="form-control" required>
                        </div>
                        <button class="btn btn-danger">ลบบัญชี</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
