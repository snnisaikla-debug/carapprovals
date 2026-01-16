@extends('layout')
@section('title','Edit Profile')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3" style="font-size:16px;">
        {{-- ใช้คำสั่ง route('approvals.index') เพื่อระบุปลายทางให้แน่นอน --}}
        <a href="{{ route('approvals.index') }}" class="btn btn-secondary">
            ← ย้อนกลับ
        </a>
    </div>
    
<div class="container" style="max-width:520px;">
    <h4 class="mb-3">Edit Profile</h4>

    {{-- 1. แสดง Error กรณีบันทึกไม่สำเร็จ --}}
    @if($errors->any())
        <div class="alert alert-danger py-2 small">
            <ul class="mb-0">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('account.updateProfile') }}">
        @csrf
        {{-- ... ฟิลด์ข้อมูล Name, Email ... --}}

        <div class="d-flex gap-2">
            <a href="{{ route('account.index') }}" class="btn btn-light w-50 border">Back</a>
            
            {{-- 2. ปุ่มบันทึกข้อมูลพร้อม id สำหรับเรียกใช้ใน JavaScript --}}
            <button type="submit" id="saveBtn" class="btn btn-danger w-50 shadow-sm">บันทึกข้อมูล</button>
        </div>
    </form>
</div>

{{-- วางต่อจากจบฟอร์มบันทึกข้อมูล --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('saveBtn');
        if (btn) {
            // 1. เปลี่ยนข้อความและสีปุ่มทันทีเมื่อโหลดหน้า
            btn.innerText = 'บันทึกสำเร็จ';
            btn.classList.replace('btn-danger', 'btn-success');

            // 2. ตั้งเวลาให้กลับเป็นสถานะปกติหลังจาก 3 วินาที
            setTimeout(() => {
                btn.innerText = 'บันทึกข้อมูล';
                btn.classList.replace('btn-success', 'btn-danger');
            }, 3000);
        }
    });
</script>
@endif
@endsection