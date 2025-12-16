<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'QRDIP') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    {{-- Custom UI --}}
    <link rel="stylesheet" href="{{ asset('css/app-ui.css') }}">
</head>

<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">QRDIP</a>

        <div class="ms-auto">
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">تسجيل الدخول</a>
                <a href="{{ route('register') }}" class="btn btn-primary">إنشاء حساب</a>
            @else
                <a href="{{ route('home') }}" class="btn btn-outline-light">لوحة التحكم</a>
            @endguest
        </div>
    </div>
</nav>

{{-- Content --}}
<main class="py-5">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="text-center py-4 text-muted">
    © {{ date('Y') }} QRDIP — جميع الحقوق محفوظة
</footer>

</body>
</html>
