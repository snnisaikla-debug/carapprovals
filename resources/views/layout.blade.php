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
    </style>
</head>
<body>

<div class="topbar mb-4">
    <div class="d-flex align-items-center gap-2">

    {{-- ปุ่มเปลี่ยนภาษา --}}
    <a href="{{ route('lang.switch', 'th') }}">
        <img src="{{ asset('images/th.png') }}" width="24" alt="TH">
    </a>
    <a href="{{ route('lang.switch', 'en') }}">
        <img src="{{ asset('images/en.png') }}" width="24" alt="EN">
    </a>

    {{-- dropdown โปรไฟล์ --}}
    <div class="dropdown">
        <button class="btn btn-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
            {{ auth()->user()->name }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="{{ route('account.show') }}">
                    {{ __('messages.my_account') }}
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

</div>

    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between align-items-center px-3">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo me-2">
                <span class="fw-bold">ฟอร์มอนุมัติการขายรถ</span>
            </div>

            @auth
                 <div class="d-flex align-items-center gap-2">
                {{-- ธงเปลี่ยนภาษา --}}
                <a href="{{ route('lang.switch', 'th') }}" class="text-decoration-none" title="ไทย">
                    <img src="{{ asset('images/flags/th.png') }}" style="width:22px;height:22px;border-radius:50%;">
                </a>
                <a href="{{ route('lang.switch', 'en') }}" class="text-decoration-none" title="English">
                    <img src="{{ asset('images/flags/en.png') }}" style="width:22px;height:22px;border-radius:50%;">
                </a>

                {{-- โปรไฟล์ --}}
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center"
                            type="button" id="profileMenu"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="rounded-circle bg-secondary text-white d-inline-flex justify-content-center align-items-center me-2"
                            style="width:28px;height:28px;">
                            {{ mb_substr(auth()->user()->name,0,1) }}
                        </span>
                        <span class="me-1">{{ auth()->user()->name }}</span>
                        <span class="text-muted">({{ strtolower(auth()->user()->role) }})</span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
                        <li>
                            <a class="dropdown-item" href="{{ route('account.show') }}">
                                บัญชีของฉัน
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    ออกจากระบบ
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        @endauth
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
