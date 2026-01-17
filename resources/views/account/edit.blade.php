@extends('layout')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('approvals.index') }}" class="btn btn-secondary">
            ← ย้อนกลับ
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-danger text-white">
            <i class="fas fa-user"></i> บัญชีของฉัน
        </div>

        <div class="card-body">

            {{-- แจ้งเตือน --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- ฟอร์มแก้ไขโปรไฟล์ --}}
            <form method="POST" action="{{ route('account.update') }}">
                @csrf

                {{-- ชื่อ - สกุล --}}
                <div class="mb-3">
                    <label class="form-label">ชื่อ - สกุล</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', Auth::user()->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- อีเมล (แก้ไม่ได้) --}}
                <div class="mb-3">
                    <label class="form-label">อีเมล</label>
                    <input type="email"
                           class="form-control"
                           value="{{ Auth::user()->email }}"
                           disabled>
                </div>

                {{-- Role (แก้ไม่ได้) --}}
                <div class="mb-3">
                    <label class="form-label">สิทธิ์ผู้ใช้งาน</label>
                    <input type="text"
                           class="form-control"
                           value="{{ Auth::user()->role }}"
                           disabled>
                </div>

                {{-- วันที่เข้าร่วม --}}
                <div class="mb-3">
                    <label class="form-label">วันที่เข้าร่วม</label>
                    <input type="text"
                           class="form-control"
                           value="{{ Auth::user()->created_at->format('d/m/Y') }}"
                           disabled>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">
                        บันทึกข้อมูล
                    </button>
                </div>
            </form>

            <hr>

            {{-- ลบบัญชี --}}
            <a href="{{ route('account.confirm-delete') }}"
                class="btn btn-danger">
                ลบบัญชี
            </a>
    </div>
</div>
        </div>
    </div>
</div>
@endsection                     