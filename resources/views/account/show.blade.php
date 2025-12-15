@extends('layout')

@section('title','My Profile')

@section('content')
<style>
  .profile-wrap{max-width:920px;margin:0 auto;}
  .card-soft{border-radius:16px;border:1px solid #e9ecef;}
  .section-title{font-size:28px;font-weight:700;margin-bottom:16px;}
  .edit-pill{border-radius:999px;padding:.45rem 1rem;}
  .rowline{display:flex;justify-content:space-between;gap:16px;padding:10px 0;border-bottom:1px solid #f1f3f5;}
  .rowline:last-child{border-bottom:0;}
  .label{color:#6c757d;width:40%;}
  .value{font-weight:600;width:60%;text-align:right;}
  @media (max-width:576px){
    .label{width:45%}
    .value{width:55%}
    .section-title{font-size:24px}
  }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="section-title">My Profile</div>

  <div class="dropdown">
    <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" style="border-radius:999px;">
      Options
    </button>
    <ul class="dropdown-menu dropdown-menu-end" style="border-radius:14px;">
      <li>
        <a class="dropdown-item" href="{{ route('account.edit') }}">
          แก้ไขข้อมูล (About)
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('account.avatar.edit') }}">
          เปลี่ยนรูปโปรไฟล์
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('account.password.edit') }}">
          เปลี่ยนรหัสผ่าน
        </a>
      </li>
      <li><hr class="dropdown-divider"></li>
      <li>
        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
          ลบบัญชี
        </button>
      </li>
    </ul>
  </div>
</div>
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:16px;">
      <div class="modal-header">
        <h5 class="modal-title text-danger">ยืนยันลบบัญชี</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" action="{{ route('account.delete') }}">
        @csrf
        <div class="modal-body">
          <p class="mb-2">การลบบัญชีเป็นแบบ <b>Soft delete</b> (ซ่อนบัญชี) สามารถกู้คืนภายหลังได้โดยแอดมิน</p>
          <div class="mb-3">
            <label class="form-label">ยืนยันรหัสผ่าน</label>
            <input type="password" name="current_password" class="form-control" required>
            @error('current_password')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
          <button class="btn btn-danger">ลบบัญชี</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection