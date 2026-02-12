<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Woods Spa - Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: url('{{ asset('assets/img/login.jpg') }}') center/cover no-repeat;
            min-height: 100vh;
            position: relative;
            font-family: "Inter", sans-serif;
        }

        /* Overlay */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(40, 30, 20, 0.65);
            backdrop-filter: blur(2px);
        }

        .login-card {
            position: relative;
            background: rgba(255,255,255,0.93);
            border: none;
            border-radius: 14px;
            padding: 35px 30px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.25);
            animation: fadeIn 0.6s ease;
        }

        .logo-text {
            font-family: "Playfair Display", serif;
            font-size: 32px;
            color: #6b4f33;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .subtitle {
            color: #a9825a;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: -5px;
        }

        .btn-custom {
            background: linear-gradient(135deg, #a9825a, #7b5a3a);
            border: none;
            font-size: 16px;
            color: white;
            padding: 12px;
            border-radius: 8px;
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #7b5a3a, #63462d);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; position: relative; z-index: 2;">
    <div class="col-10 col-md-6 col-lg-4 mx-auto">">

        <div class="login-card">

            <div class="text-center mb-4">
                <div class="logo-text">WOODS SPA</div>
                <div class="subtitle">Admin Login</div>
            </div>

            {{-- Hiển thị lỗi --}}
            @if($errors->any())
                <div class="alert alert-danger text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-custom w-100 mt-3">Đăng nhập</button>
            </form>

        </div>

    </div>
</div>

</body>
</html>
