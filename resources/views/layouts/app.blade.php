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
    <div class="container d-flex align-items-center">

        {{-- Brand --}}
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <img src="{{ asset('images/qrdip-logo.png') }}"
                 alt="QRDIP Logo"
                 style="height:50px; width:auto;">
            <span class="fw-bold">
                {{ __('messages.app_name') }}
            </span>
        </a>

        {{-- Back Button (hidden on welcome) --}}
        @if (!request()->routeIs('welcome'))
            <button type="button"
        onclick="window.history.back()"
        class="btn btn-outline-light btn-sm ms-2">
    ⬅ {{ __('messages.back') }}
</button>

        @endif

        {{-- Home Button (Admin + Manager only, hidden on booking pages) --}}
        @auth
            @php
                $role = auth()->user()->role;

                $hideHome =
                    request()->is('org/*') ||
                    request()->is('booking/*') ||
                    request()->is('my-bookings');
            @endphp

            @if(!$hideHome)
                @if($role === 'admin')
                    <a href="{{ route('admin.users.index') }}"
                       class="btn btn-outline-light btn-sm mx-2">
                        🏠 {{ __('messages.home') }}
                    </a>
                @elseif($role === 'manager')
                    <a href="{{ route('manager.dashboard') }}"
                       class="btn btn-outline-light btn-sm mx-2">
                        🏠 {{ __('messages.home') }}
                    </a>
                @endif
            @endif
        @endauth

        {{-- Right Side --}}
        <div class="ms-auto d-flex align-items-center gap-2">

            {{-- Language --}}
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

            {{-- Auth --}}
            @auth

                @if(auth()->user()->role === 'user')
                    <a href="{{ route('customer.bookings') }}"
                       class="btn btn-outline-info btn-sm">
                        📅 {{ __('messages.my_bookings') }}
                    </a>
                @endif

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.users.index') }}"
                       class="btn btn-outline-danger btn-sm">
                        🛡 {{ __('messages.admin_panel') }}
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
