{{-- resources/views/layout_auth.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'เข้าสู่ระบบ')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background-color: #05051c; /* พื้นหลังมืดแบบในรูป */
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 380px;              /* ความกว้างกล่อง */
            background-color: #ffffff;
            border-radius: 28px;
            padding: 32px 28px 36px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-logo img {
            height: 70px;
        }

        .auth-title {
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .auth-label {
            font-size: 14px;
            margin-bottom: 4px;
        }

        .auth-input {
            font-size: 14px;
            padding: 8px 10px;
            border-radius: 8px;
        }

        .auth-help {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 2px;
        }

        .auth-btn-main {
            background-color: #4f8bff;
            border-color: #4f8bff;
            font-weight: 600;
            font-size: 15px;
            padding: 10px 0;
            border-radius: 10px;
        }

        .auth-btn-main:hover {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .auth-bottom-link {
            font-size: 13px;
            margin-top: 10px;
            text-align: center;
        }

        .auth-bottom-link a {
            color: #3b82f6;
            text-decoration: none;
        }

        .auth-bottom-link a:hover {
            text-decoration: underline;
        }

        .reset-link {
            font-size: 12px;
        }

        .remember-label {
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Mitsubishi Motors">
    </div>

    @yield('content')
</div>

</body>
</html>
