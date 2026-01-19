@extends('layout')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('approvals.index') }}" class="btn btn-secondary">
            {{ __('messages.back') }}
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-danger text-white">
            <i class="fas fa-user"></i> {{ __('messages.myaccount') }}
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
                    <label class="form-label">{{ __('messages.name') }}</label>
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
                    <label class="form-label">{{ __('messages.email') }}</label>
                    <input type="email"
                           class="form-control"
                           value="{{ Auth::user()->email }}"
                           disabled>
                </div>

                {{-- Role (แก้ไม่ได้) --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.role') }}</label>
                    <input type="text"
                           class="form-control"
                           value="{{ Auth::user()->role }}"
                           disabled>
                </div>

                {{-- วันที่เข้าร่วม --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.email') }}</label>
                    <input type="text"
                           class="form-control"
                           value="{{ Auth::user()->created_at->format('d/m/Y') }}"
                           disabled>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('messages.save') }}
                    </button>
                </div>
            </form>

            <hr>

            {{-- ลบบัญชี --}}
            <a href="{{ route('account.confirm-delete') }}"
                class="btn btn-danger">
                {{ __('messages.deleteacc') }}
            </a>
    </div>
</div>
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