<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Car Approval')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #ffffffff; /* พื้นหลัง เทาอ่อน */
        }
        .topbar {
            background-color: #b91c1c; /* แดงล้วน */
            padding: 10px 0;
            color: #ffffffff;  /* ตัวหนังสือชื่อระบบ */
        }
        .topbar .logo {
            height: 40px;
        }
        .topbar{
        background:#b0120a;
        padding:8px 0;
        }

        .bg-pink { background-color: #ec4899 !important; }   /* pink */
        .bg-orange { background-color: #f97316 !important; } /* orange */

    </style>
</head>
<body>

<div class="topbar mb-4">
     <div class="container-fluid d-flex align-items-center px-3">

        {{-- โลโก้ + ชื่อระบบ --}}
        <div class="d-flex justify-content-between align-items-center px-3">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo me-2">
                <span class="fw-bold">ฟอร์มอนุมัติการขายรถ</span>
            </div>
        </div>

{{-- ขวา: ปุ่มภาษา (ปุ่มเดียวสลับ) + บัญชีของฉัน --}}
<div class="d-flex align-items-center gap-2 ms-auto">

        {{-- ปุ่มสลับภาษา (ปุ่มเดียว) --}}
        <a href="{{ route('lang.toggle') }}"
            class="btn-sm">
      
        @php $lang = session('lang', 'th'); @endphp
        @if($lang === 'th')
          <span><img src="{{ asset('images/flags/th.png') }}" 
          style="width:22px;height:22px;border-radius:50%;"></span>
        @else
          <span><img src="{{ asset('images/flags/en.png') }}" 
          style="width:22px;height:22px;border-radius:50%;"></span>
        @endif
        </a>

      {{-- โปรไฟล์ --}}
        <div class="dropdown">
            @auth
            <button class="btn btn-light btn-sm dropdown-toggle"
                    data-bs-toggle="dropdown">
            {{ auth()->user()->name }}
            </button>
            @endauth

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('account.show') }}">บัญชีของฉัน</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger">ออกจากระบบ</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

  </div>
</div>    

<div class="container mb-4">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</body>
</html>
