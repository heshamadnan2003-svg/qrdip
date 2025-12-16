@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row align-items-center mb-5">

        {{-- النص الرئيسي --}}
        <div class="col-md-6 mb-4">
            <h1 class="fw-bold mb-3">
                مرحبًا بك في <span class="text-primary">QRDIP</span>
            </h1>

            <p class="text-muted fs-5 mb-4">
                منصة ذكية لإدارة الحجوزات باستخدام رمز QR،  
                تمكّن مقدمي الخدمات من تنظيم مواعيدهم  
                وتسهّل على الزبائن عملية الحجز.
            </p>

            <div class="d-flex gap-3 flex-wrap">
                

                @auth
                    <a href="{{ route('home') }}" class="btn btn-success btn-lg">
                        الذهاب إلى لوحة التحكم
                    </a>
                @endauth
            </div>
        </div>

        {{-- صورة --}}
        <div class="col-md-6 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/2920/2920277.png"
                 alt="QR Booking"
                 class="img-fluid"
                 style="max-width: 320px">
        </div>

    </div>

    {{-- شرح طريقة العمل --}}
    <div class="row text-center">

        <h3 class="section-title mb-4">كيف يعمل QRDIP؟</h3>

        <div class="col-md-3 mb-4">
            <div class="ui-card h-100">
                <h5 class="mb-2">📝 تسجيل النشاط</h5>
                <p class="text-muted mb-0">
                    يقوم مقدم الخدمة بإنشاء حساب وإدخال بيانات نشاطه وخدماته
                </p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="ui-card h-100">
                <h5 class="mb-2">⚙️ إنشاء الصفحة</h5>
                <p class="text-muted mb-0">
                    يتم إنشاء صفحة خاصة ورمز QR تلقائيًا لكل نشاط
                </p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="ui-card h-100">
                <h5 class="mb-2">📱 مسح الرمز</h5>
                <p class="text-muted mb-0">
                    يقوم الزبون بمسح رمز QR للاطلاع على الخدمات والمواعيد
                </p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="ui-card h-100">
                <h5 class="mb-2">✅ الحجز</h5>
                <p class="text-muted mb-0">
                    يتم الحجز بسهولة ويصل الطلب مباشرة لمقدم الخدمة
                </p>
            </div>
        </div>

    </div>

</div>
@endsection
