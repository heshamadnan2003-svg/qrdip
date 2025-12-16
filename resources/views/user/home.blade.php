@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">👋 مرحبًا {{ auth()->user()->name }}</h2>

    <p class="text-muted mb-4">
        من هنا يمكنك حجز مواعيدك وإدارة حسابك بسهولة
    </p>

    <div class="row">

        {{-- كرت حجوزاتي --}}
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5>📅 حجوزاتي</h5>
                    <p class="text-muted">عرض وإدارة مواعيدك</p>

                    <a href="{{ route('user.bookings') }}"
                       class="btn btn-primary w-100">
                        عرض الحجوزات
                    </a>
                </div>
            </div>
        </div>

        {{-- كرت استكشاف --}}
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5>🔍 استكشاف الخدمات</h5>
                    <p class="text-muted">ابحث عن مقدمي الخدمات</p>

                    <a href="{{ url('/') }}"
                       class="btn btn-outline-primary w-100">
                        استكشاف
                    </a>
                </div>
            </div>
        </div>

        {{-- كرت التحول إلى مقدم خدمة --}}
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">

                    @if(auth()->user()->organization)
                        <h5>🧑‍💼 لوحة التحكم</h5>
                        <p class="text-muted">أنت مقدم خدمة بالفعل</p>

                        <a href="{{ route('manager.dashboard') }}"
                           class="btn btn-success w-100">
                            الدخول للوحة التحكم
                        </a>
                    @else
                        <h5>✂️ كن مقدم خدمة</h5>
                        <p class="text-muted">سجّل عملك وابدأ استقبال الحجوزات</p>

                        <a href="{{ route('provider.apply') }}"
                           class="btn btn-success w-100">
                            التسجيل كمقدم خدمة
                        </a>
                    @endif

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
