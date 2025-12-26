<!doctype html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('messages.app_name') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    @if(app()->getLocale() === 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    {{-- Custom UI --}}
    <link rel="stylesheet" href="{{ asset('css/app-ui.css') }}">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">

        {{-- Brand --}}
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            {{ __('messages.app_name') }}
        </a>

        {{-- Home Button --}}
        @auth
            @if(auth()->user()->role === 'manager')
                <a href="{{ route('manager.dashboard') }}"
                   class="btn btn-outline-light btn-sm ms-2">
                    🏠 {{ __('messages.home') }}
                </a>
            @else
                <a href="{{ route('user.home') }}"
                   class="btn btn-outline-light btn-sm ms-2">
                    🏠 {{ __('messages.home') }}
                </a>
            @endif
        @else
            <a href="{{ url('/') }}"
               class="btn btn-outline-light btn-sm ms-2">
                🏠 {{ __('messages.home') }}
            </a>
        @endauth

        {{-- Right Side --}}
        <div class="ms-auto d-flex align-items-center gap-2">

            {{-- Language Switch --}}
            <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
               class="btn btn-outline-light btn-sm">
                {{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}
            </a>

            {{-- Dark Mode --}}
            <button type="button"
                    id="toggleDarkMode"
                    class="btn btn-outline-light btn-sm">
                🌙
            </button>

            {{-- User Buttons --}}
            @auth
                @if(!auth()->user()->organization)
    <a href="{{ route('customer.bookings') }}"
       class="btn btn-outline-info btn-sm">
        📅 {{ __('messages.my_bookings') }}
    </a>
@endif


                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger btn-sm">
                        🚪 {{ __('messages.logout') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                    {{ __('messages.login') }}
                </a>

                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                    {{ __('messages.register') }}
                </a>
            @endauth

        </div>
    </div>
</nav>

<main class="py-5">
    @yield('content')
</main>

{{-- Alerts --}}
@if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show">
            ❌ {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<footer class="text-center py-3 text-muted">
    © {{ date('Y') }} {{ __('messages.app_name') }}
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- Dark Mode Script --}}
<script>
(function () {
    const body = document.body;
    const btn  = document.getElementById('toggleDarkMode');

    if (localStorage.getItem('darkMode') === 'on') {
        body.classList.add('dark-mode');
        if (btn) btn.innerText = '☀️';
    }

    if (btn) {
        btn.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            const isDark = body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDark ? 'on' : 'off');
            btn.innerText = isDark ? '☀️' : '🌙';
        });
    }
})();
</script>

</body>
</html>
