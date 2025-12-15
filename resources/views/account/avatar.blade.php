@extends('layout')
@section('title','Change Avatar')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css">

<div class="container" style="max-width:720px;">
  <h4 class="mb-3">เปลี่ยนรูปโปรไฟล์</h4>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <div class="card" style="border-radius:16px;">
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label">เลือกรูป</label>
        <input type="file" id="avatarFile" accept="image/*" class="form-control">
        <div class="form-text">แนะนำรูปสี่เหลี่ยม/หน้าตรง ระบบจะ crop เป็นวงกลมตอนแสดงผล</div>
      </div>

      <div class="border rounded-3 p-2 mb-3" style="max-height:420px; overflow:hidden;">
        <img id="preview" style="max-width:100%; display:none;">
      </div>

      <form method="POST" action="{{ route('account.avatar.update') }}">
        @csrf
        <input type="hidden" name="avatar_data" id="avatar_data">

        <div class="d-flex gap-2">
          <a href="{{ route('account.show') }}" class="btn btn-light w-50">Back</a>
          <button type="button" id="saveBtn" class="btn btn-primary w-50" disabled>Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>
<script>
  let cropper = null;

  const fileInput = document.getElementById('avatarFile');
  const img = document.getElementById('preview');
  const saveBtn = document.getElementById('saveBtn');
  const avatarData = document.getElementById('avatar_data');

  fileInput.addEventListener('change', (e) => {
    const file = e.target.files?.[0];
    if (!file) return;

    const url = URL.createObjectURL(file);
    img.src = url;
    img.style.display = 'block';

    if (cropper) cropper.destroy();
    cropper = new Cropper(img, {
      aspectRatio: 1,
      viewMode: 1,
      autoCropArea: 1,
    });

    saveBtn.disabled = false;
  });

  saveBtn.addEventListener('click', () => {
    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
      width: 512,
      height: 512,
      imageSmoothingQuality: 'high'
    });

    avatarData.value = canvas.toDataURL('image/png');
    saveBtn.closest('form').submit();
  });
</script>
@endsection
