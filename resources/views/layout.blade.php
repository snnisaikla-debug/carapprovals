<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Car Approval')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    
    <style>
        body {
            background-color: #ffffffff; /* พื้นหลัง เทาอ่อน */
        }
        .topbar {
            background-color: #b91c1c; /* แดงล้วน */
            padding: 10px 0;
            color: #fff;
        }
        .topbar .logo {
            height: 40px;
        }
    </style>
</head>
<body>

<div class="topbar mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo me-2">
            <span class="fw-bold">ฟอร์มอนุมัติการขายรถ</span>
        </div>

        @auth
            <div class="dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center"
                        type="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- ไอคอนโปรไฟล์กลม ๆ --}}
                    <span class="rounded-circle bg-secondary text-white d-inline-flex justify-content-center align-items-center me-2"
                          style="width:28px;height:28px;">
                        {{ mb_substr(auth()->user()->name,0,1) }}
                    </span>
                    <span class="me-1">{{ auth()->user()->name }}</span>
                    <span class="text-muted">({{ auth()->user()->role }})</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
                    <li>
                        <a class="dropdown-item" href="{{ route('account.show') }}">
                            บัญชีของฉัน
                        </a>
                    </li>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">

                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                ออกจากระบบ
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @endauth
    </div>
</div>

<div class="container mb-4">
    @yield('content')
</div>
</body>
</html>
