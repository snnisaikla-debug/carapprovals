@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if (session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-key"></i> เปลี่ยนรหัสผ่าน (Change Password)
                </div>
                <div class="card-body">
                    <form action="{{ route('account.password.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>รหัสผ่านปัจจุบัน</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label>รหัสผ่านใหม่</label>
                                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                                @error('new_password') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label>ยืนยันรหัสผ่านใหม่</label>
                                <input type="password" name="new_password_confirmation" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">ยืนยันเปลี่ยนรหัสผ่านใหม่</button>
                    </form>
                </div>
            </div>

            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
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
                            <input type="email" name="new_email" class="form-control @error('new_email') is-invalid @enderror" placeholder="example@mail.com">
                            @error('new_email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label>ยืนยันด้วยรหัสผ่านปัจจุบัน</label>
                            <input type="password" name="current_password_for_email" class="form-control @error('current_password_for_email') is-invalid @enderror">
                            @error('current_password_for_email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-warning">ส่งลิงก์ยืนยันไปที่อีเมลใหม่</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection