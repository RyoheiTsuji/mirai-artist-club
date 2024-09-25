<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mirai Artist Club') }}</title>
    <!-- favicons -->
    <link rel="icon" href="{{ asset('storage/favicon/favicon.ico') }}" sizes="32x32"><!-- 32×32 -->
    <link rel="icon" href="{{ asset('storage/favicon/icon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('storage/favicon/apple-touch-icon.png') }}"><!-- 180×180 -->
    <link rel="manifest" href="{{ asset('storage/favicon/manifest.webmanifest') }}">
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}?v={{ time() }}">
    <!-- Scripts -->
    <script src="{{ asset('js/admin_app.js') }}" defer></script>
</head>
<body>
@include('components.header_admin')
<div class="container-fluid">
    <div class="row">
        <!-- 左カラム：ナビゲーションメニュー -->
        <div class="col-auto" id="sidebar">
            @include('components.nav_admin')
        </div>

        <!-- 右カラム：コンテンツ表示用 -->
        <div class="col" id="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/message.js') }}"></script>
@stack('scripts')
</body>

</html>
