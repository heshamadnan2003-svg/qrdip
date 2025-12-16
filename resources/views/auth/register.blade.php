@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center">
    <div class="auth-card w-100" style="max-width: 460px">

        <h3 class="auth-title text-center">📝 إنشاء حساب جديد</h3>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">الاسم</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100 mb-3">
                إنشاء الحساب
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}" class="auth-link">
                    لديك حساب؟ تسجيل الدخول
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
