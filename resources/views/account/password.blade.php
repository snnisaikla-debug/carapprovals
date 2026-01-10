@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card" style="max-width: 500px; margin: 0 auto;">
        <div class="card-header">เปลี่ยนรหัสผ่าน</div>
        <div class="card-body">
            {{-- แสดงข้อความสำเร็จ --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('account.password.update') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label>รหัสผ่านปัจจุบัน</label>
                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                    @error('current_password') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label>รหัสผ่านใหม่</label>
                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                    @error('new_password') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label>ยืนยันรหัสผ่านใหม่</label>
                    <input type="password" name="new_password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary w-100">บันทึกรหัสผ่าน</button>
            </form>
        </div>
    </div>
</div>
@endsection