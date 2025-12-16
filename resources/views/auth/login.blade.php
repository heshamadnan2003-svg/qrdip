@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center">
    <div class="auth-card w-100" style="max-width: 420px">

        <h3 class="auth-title text-center">🔐 تسجيل الدخول</h3>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100 mb-3">
                دخول
            </button>

            <div class="text-center">
                <a href="{{ route('register') }}" class="auth-link">
                    ليس لديك حساب؟ إنشاء حساب
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
