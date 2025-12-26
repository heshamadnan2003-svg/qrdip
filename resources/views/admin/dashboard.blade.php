{{ auth()->user()->role }}

@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">🛡️ لوحة تحكم ADMIN</h3>

    <div class="row g-3">

        <div class="col-md-3">
            <a href="{{ route('manager.dashboard') }}" class="card p-3 text-center text-decoration-none">
                🧑‍💼 Dashboard المدير
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('user.home') }}" class="card p-3 text-center text-decoration-none">
                👤 Home المستخدم
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('manager.services') }}" class="card p-3 text-center text-decoration-none">
                ✂️ الخدمات
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('manager.working-hours') }}" class="card p-3 text-center text-decoration-none">
                🕒 أوقات الدوام
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('org.show', optional(auth()->user()->organization)->slug ?? '') }}"
               class="card p-3 text-center text-decoration-none">
                🌍 الصفحة العامة
            </a>
        </div>

        <div class="col-md-3">
            <a href="/_test" class="card p-3 text-center text-decoration-none">
                🧪 Test Route
            </a>
        </div>

    </div>
</div>
@endsection
