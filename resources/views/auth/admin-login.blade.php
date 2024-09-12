<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面ログイン</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans JP', 'Roboto', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-logo {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .form-control {
            margin-bottom: 15px;
            padding-left: 40px;
        }
        .form-icon {
            position: absolute;
            left: 10px;
            top: 40%;
            transform: translateY(-50%);
            color: #007bff;
            z-index: 10;
        }
        .input-group {
            position: relative;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-check-label {
            font-weight: normal;
        }
    </style>
</head>
<body>

<div class="login-container">
    <img src="{{ asset('storage/img/logo_w500.gif') }}" alt="Logo" class="login-logo">
    <h2 style="font-size:1.5rem;">管理画面ログイン</h2>
    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <!-- Email input with FontAwesome icon -->
        <div class="input-group mb-3">
            <i class="fas fa-envelope form-icon"></i>
            <input type="email" class="form-control" id="email" name="email" placeholder="メールアドレス" required>
        </div>
        <!-- Password input with FontAwesome icon -->
        <div class="input-group mb-3">
            <i class="fas fa-lock form-icon"></i>
            <input type="password" class="form-control" id="password" name="password" placeholder="パスワード" required>
        </div>
        <div class="mb-3 form-check text-start">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">ログイン状態を保持する</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">ログイン</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
